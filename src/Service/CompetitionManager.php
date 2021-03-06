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
    private $em;
    private $competitionRepository;
    private $competitionDocsRepository;
    private $exitMessage;
    private $documentsBase;

    public function __construct($publicDir, $competitionDocumentsDir, EntityManagerInterface $em, CompetitionRepository $competitionRepository, CompetitionDocumentRepository $competitionDocumentRepository, CompetitionEnrolmentRepository $competitionEnrolmentRepository )
    {
        $this->em = $em;
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
                    $this->em->remove($doc);
                    $cnt_rem++;
                }
            } else {
                $this->em->remove($doc);
                $cnt_rem++;
            }
        }
        $this->exitMessage[] = array( 'alert' => 'success', 'html' => sprintf('Removed %d/%d documents.', $cnt_rem, $cnt_doc) );

        $cnt_rem = 0;
        $enrolments = $this->competitionEnrolmentRepository->findPastIrrelevantCompetitionEnrolments();
        foreach( $enrolments as $enrolment ) {
            $this->em->remove($enrolment);
            $cnt_rem++;
        }
        $this->exitMessage[] = array( 'alert' => 'success', 'html' => sprintf('Removed %d irrelevant enrolments.', $cnt_rem) );

        $this->em->flush();

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
                    $this->em->persist($competitionPart);
                    $add_parts++;
                }
            }
        }
        $this->em->flush();
        $this->exitMessage[] = array( 'alert' => 'success', 'html' => sprintf('Added %d/%d parts.', $add_parts, $all_parts) );

        return true;
    }

    public function addCompetitionPartEnrolments(CompetitionPart $competitionPart, bool $flush=true, bool $message=true): ?int
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
                $this->em->persist($enrolment);
                $add++;
            }
        }

        if ($flush) $this->em->flush();
        if ($message) $this->exitMessage[] = array( 'alert' => 'success', 'html' => sprintf('Added %d of %d enrolments.', $add, $all) );

        return $add;
    }

    public function filterCompetitionEnrolments(Competition $competition, bool $flush=true, bool $remove=false): ?bool
    {
        $all=0; $upd=0; $rem=0; $add=0;

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
                        $this->em->remove($enrolment);
                        $rem++;
                    } else {
                        $enrolment->setFiltered(false);
                        $upd++;
                    }
                }
            }
            $add += $this->addCompetitionPartEnrolments($competitionPart, false, false);
        }

        if ($flush) $this->em->flush();
        $this->exitMessage[] = array(
            'alert' => 'success', 
            'html' => sprintf('Verified %d erolments: %d updated %d added %d removed.', $all, $upd, $add, $rem)
        );

        return true;
    }

    public function disableMemberEnrolments(Member $member, bool $flush=true): ?bool
    {
        $upd=0;

        foreach ($this->competitionEnrolmentRepository->findUpcomingMemberCompetitionEnrolments($member) as $enrolment)
        {
            $enrolment->setFiltered(false);
            $upd++;
        }

        if ($flush) $this->em->flush();
        $this->exitMessage[] = array(
            'alert' => 'success',
             'html' => sprintf('Disabled %d enrolments for member %s.', $member->getName(), $upd)
        );

        return true;
    }

    public function verifyMemberEnrolments(Member $member, bool $flush=true): ?bool
    {
        $add=0; $upd=0;

        $team = $member->getTeam();
        if (is_null($team)) return false;

        $enrolled = $team->getDefaultEnrolled();

        foreach ($this->competitionEnrolmentRepository->findUpcomingMemberCompetitionEnrolmentsNotTeam($member,$team) as $enrolment)
        {
            $enrolment->setFiltered(false);
        }

        foreach ($this->competitionRepository->findUpcomingCompetitionsByTeam($team) as $competition)
        {
            $filtered = $this->memberCompliantWithCompetition($member,$competition);
            foreach ($competition->getEnabledCompetitionParts() as $competitionPart)
            {
                if ($enrolment = $competitionPart->getMemberEnrolment($member)) 
                {
                    if ($enrolment->getFiltered() !== $filtered) {
                        $enrolment->setFiltered($filtered);
                        $upd++;
                    }
                } else {
                    $enrolment = new CompetitionEnrolment($competitionPart, $member, $enrolled, $filtered, $competition->getRestrictions());
                    $this->em->persist($enrolment);
                    $add++;
                }
            }
        }

        if ($flush) $this->em->flush();
        $this->exitMessage[] = array(
            'alert' => 'success', 
             'html' => sprintf('Verified enrolments for member %s: %d added %d updated.', $member->getName(), $add, $upd)
        );

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

    public function getUnnotifiedUserCompetitions(User $user, \DateTimeInterface $reftime=null ): array 
    {
        return $this->competitionRepository->findUnnotifiedCompetitionsByUser($user, $reftime);
    }

    public function getPeriodUserCompetitions(User $user, \DateTimeInterface $periodStart, \DateTimeInterface $periodEnd ): array 
    {
        return $this->competitionRepository->findCompetitionsByUser($user, $periodStart, $periodEnd);
    }

    public function getPeriodCompetitions(\DateTimeInterface $periodStart, \DateTimeInterface $periodEnd ): array 
    {
        return $this->competitionRepository->findCompetitions($periodStart, $periodEnd);
    }

    public function getUpcomingCompetitions(\DateTimeInterface $reftime=null): array 
    {
        return $this->competitionRepository->findUpcomingCompetitions($reftime);
    }

    public function getCompetition(int $id): ?Competition 
    {
        return $this->competitionRepository->findCompetition($id);
    }

    public function getCompetitionEnrolments(int $id): array 
    {
        if ($competition = $this->competitionRepository->find($id)) {
            return $this->competitionEnrolmentRepository->findCompetitionEnrolments($competition);
        } else {
            return [];
        }
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

    public function getUserNotificationList(): array
    {
        $dow = date('N', (new \DateTime('today'))->getTimestamp()); // get day of week
        
    }

    public function notifyUsers(): bool 
    {
        $users = $this->getUserNotificationList();
        foreach ($users as $user) {
            $competitions = $this->getUnnotifiedUserCompetitions();
            // set notified to true
            // flush
            // render email
            // send email (add to list)
        }
    }

    public function getExitMessage(): ?array
    {
        return $this->exitMessage;
    }

}
