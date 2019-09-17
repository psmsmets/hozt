<?php

namespace App\Service;

use App\Entity\Competition;
use App\Entity\CompetitionDocument;
use App\Entity\CompetitionPart;
use App\Entity\CompetitionEnrolment;
use App\Entity\Member;
use App\Entity\User;
use App\Repository\CompetitionRepository;
use App\Repository\CompetitionPartRepository;
use App\Repository\CompetitionEnrolmentRepository;
use App\Repository\CompetitionDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

class CompetitionManager 
{
    private $entityManager;
    private $competitionRepository;
    private $competitionDocsRepository;
    private $exitMessage;
    private $documentsBase;

    public function __construct($publicDir, $competitionDocumentsDir, EntityManagerInterface $entityManager, CompetitionRepository $competitionRepository, CompetitionDocumentRepository $competitionDocumentRepository, CompetitionEnrolmentRepository $competitionEnrolmentRepository )
    {
        $this->entityManager = $entityManager;
        $this->competitionRepository = $competitionRepository;
        $this->competitionDocumentRepository = $competitionDocumentRepository;
        $this->competitionEnrolmentRepository = $competitionEnrolmentRepository;
        $this->dir = ltrim(rtrim($publicDir, '/'), '/') .'/'. ltrim(rtrim($competitionDocumentsDir, '/'), '/');
        $this->exitMessage = array();
    }

    public function autoCleanup(): ?bool
    {
        $filesystem = new Filesystem();
        $cnt_doc = 0; $cnt_rem = 0;
        $docs = $this->competitionDocumentRepository->findPastCompetitionDocuments();
        $reftime = new \DateTimeImmutable('today midnight');

        foreach( $docs as $doc) {
            $cat = $doc->getCategory();
            if ( !$cat->getAutoCleanup() ) continue;

            $endTime = $doc->getCompetition()->getCalendar()->calcEndTime();
            if ($reftime->modify(sprintf("- %d days", $cat->getCleanupDelay())) <= $endTime) continue;

            $cnt_doc++;
            
            if ($file = $doc->getDocument()) {
                $fullfile = sprintf('%s/%s', $this->dir, $file);
                if ($filesystem->exists($fullfile)) {
                    $filesystem->remove($fullfile);
                    $this->entityManager->remove($doc);
                    $cnt_rem++;
                }
            } else {
                $this->entityManager->remove($doc);
                $cnt_rem++;
            }
        }
        $this->entityManager->flush();
        $this->exitMessage[] = sprintf('Removed %d/%d documents.', $cnt_rem, $cnt_doc);

        return true;
    }

    public function addDayParts(Competition $competition, array $parts = null): ?bool
    {
        $days = $competition->getCalendar()->getListOfDays();
        $parts = is_null($parts) ? $competition->getPartList(): $parts;
        sort($parts);

        $all_parts = 0; $add_parts = 0;

        foreach( $days as $day) {
            foreach( $parts as $part ) {
                $all_parts++;
                if (!$competition->competitionPartExists($day,$part)) {
                    $competitionPart = new CompetitionPart($competition,$day,$part);
                    $this->entityManager->persist($competitionPart);
                    $add_parts++;
                }
            }
        }
        $this->entityManager->flush();
        $this->exitMessage[] = sprintf('Added %d/%d parts.', $add_parts, $all_parts);

        return true;
    }

    public function addCompetitionPartEnrolments(CompetitionPart $competitionPart, bool $flush=true): ?bool
    {
        $competition = $competitionPart->getCompetition();
        $all=0; $add=0;

        foreach ($competition->getTeams() as $team) {
            foreach ($team->getMembers() as $member) {
                $all++;
                if ($competitionPart->hasMemberEnrolment($member)) continue;
                $enrolment = new CompetitionEnrolment(
                    $competitionPart,
                    $member, 
                    $team->getDefaultEnrolled(),
                    $this->memberCompliantWithCompetition($member,$competition),
                    $competition->getRestrictions()
                );
                $this->entityManager->persist($enrolment);
                $add++;
            }
        }

        if ($flush) $this->entityManager->flush();
        $this->exitMessage[] = sprintf('Added %d of %d enrolments.', $add, $all);

        return true;
    }

    public function filterCompetitionEnrolments(Competition $competition, bool $flush=true, bool $remove=false): ?bool
    {
        $all=0; $upd=0; $rem=0;

        foreach ($competition->getEnabledCompetitionParts() as $competitionPart) {
            foreach( $competitionPart->getEnrolments() as $enrolment ) {
                $all++;
                $member = $enrolment->getMember();
                if ($competition->getTeams()->contains($member->getTeam())) {
                    $enrolment->updateEnrolment(
                        $this->memberCompliantWithCompetition($member,$competition),
                        $competition->getRestrictions()
                    );
                    $upd++;
                } else {
                    if ($remove) {
                        $this->entityManager->remove($enrolment);
                        $rem++;
                    } else {
                        $enrolment->setFiltered(false);
                        $upd++;
                    }
                }
            }
        }

        if ($flush) $this->entityManager->flush();
        $this->exitMessage[] = sprintf('Verified %d erolments: %d updated %d removed.', $all, $upd, $rem);

        return true;
    }

    public function verifyMemberEnrolments(Member $member, bool $flush=true): ?bool
    {
        $add=0; $upd=0;

        $team = $member->getTeam();
        foreach ($member->getActiveCompetitionEnrolmentsFromDate() as $enrolment)
        {
            if (!$enrolment->getCompetition()->getTeams()->contains($team)) {
                $enrolment->setFiltered(false);
                $upd++;
            }
        }

        $enrolled = $team()->getDefaultEnrolled();
        foreach ($team->getEnabledCompetitionsFromDate() as $competition)
        {
            $filtered = $this->memberCompliantWithCompetition($member,$competition);
            foreach ($competition->getEnabledCompetitionParts() as $competitionPart)
            {
                if ($enrolment = $competitionPart->getMemberEnrolment($member)) continue;
                $enrolment = new CompetitionEnrolment( $competitionPart, $member, $enrolled, $filtered, $competition->getRestrictions() );
                $this->entityManager->persist($enrolment);
                $add++;
            }
        }

        if ($flush) $this->entityManager->flush();
        $this->exitMessage[] = sprintf('Verified enrolments for member %s: %d added %d updated.', $member->getName(), $add, $upd);
        return true;
    }

    public function memberCompliantWithCompetition(Member $member, Competition $competition): ?bool
    {
        if ( $competition->getRegistrationId() and is_null($member->getRegistrationId()) ) return false;
        $birthyear = $member->getBirthyear();
        if ( $member->isMale() ) {
            return $birthyear >= $competition->getMaleBirthyearMin() and $birthyear <= $competition->getMaleBirthyearMax();
        } else {
            return $birthyear >= $competition->getFemaleBirthyearMin() and $birthyear <= $competition->getFemaleBirthyearMax();
        }
    }

    public function getUserEnrolments(User $user, \DateTimeInterface $start, \DateTimeInterface $end): array 
    {
        return $this->competitionEnrolmentRepository->findCompetitionEnrolmentsByUser($user, $start, $end);
    }

    public function getUpcomingUserCompetitions(User $user, \DateTimeInterface $reftime=null ): array 
    {
        return $this->competitionRepository->findUpcomingCompetitionsByUser($user, $reftime);
    }

    public function getNewUserCompetitions(User $user, \DateTimeInterface $reftime=null ): array 
    {
        return $this->competitionRepository->findNewCompetitionsByUser($user, $reftime);
    }

    public function getPeriodUserCompetitions(User $user, \DateTimeInterface $periodStart, \DateTimeInterface $periodEnd ): array 
    {
        return $this->competitionRepository->findCompetitionsByUser($user, $periodStart, $periodEnd);
    }

    public function getPeriodCompetitions(\DateTimeInterface $periodStart, \DateTimeInterface $periodEnd ): array 
    {
        return $this->competitionRepository->findCompetitions($periodStart, $periodEnd);
    }

    public function toggleCompetition(User $user, int $competitionPartId, int $memberId, bool $enrolled): bool 
    {
        $enrolment = $this->competitionEnrolmentRepository->findUserCompetitionEnrolment( 
                $user, $competitionPartId, $memberId
            );
        if (is_null($enrolment)) return false;

        $now = new \DateTime('now');
        if ($now > $enrolment->getCompetitionPart()->getCompetition()->getEnrolBefore()) return false;

        $enrolment->setEnrolled($enrolled);
        $this->competitionEnrolmentRepository->flush();

        return true;
    }

    public function getExitMessage(): ?array
    {
        return $this->exitMessage;
    }

}
