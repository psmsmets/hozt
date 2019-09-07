<?php

namespace App\Service;

use App\Entity\Competition;
use App\Entity\CompetitionDocument;
use App\Entity\CompetitionPart;
use App\Entity\CompetitionEnrolment;
use App\Entity\Member;
use App\Repository\CompetitionRepository;
use App\Repository\CompetitionPartRepository;
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

    public function __construct($publicDir, $competitionDocumentsDir, EntityManagerInterface $entityManager, CompetitionRepository $competitionRepository, CompetitionDocumentRepository $competitionDocumentRepository )
    {
        $this->entityManager = $entityManager;
        $this->competitionRepository = $competitionRepository;
        $this->competitionDocumentRepository = $competitionDocumentRepository;
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
                    $competition->getRestrictions() ? false : $team->getDefaultEnrolled(),
                    !$this->memberCompliantWithCompetition($member,$competition)
                );
                $this->entityManager->persist($enrolment);
                $add++;
            }
        }

        if ($flush) $this->entityManager->flush();
        $this->exitMessage[] = sprintf('Added %d/%d enrolments.', $add, $all);

        return true;
    }

    public function verifyCompetitionEnrolments(Competition $competition, bool $remove=false, bool $flush=true): ?bool
    {
        $all=0; $upd=0; $rem=0;

        foreach ($competition->getEnabledCompetitionParts() as $competitionPart) {
            foreach( $competitionPart->getEnrolments() as $enrolment ) {
                $all++;
                if ($enrolment->getTeam() === $member->getTeam()) {
                    $enrolment->setDisabled(!$this->memberCompliantWithCompetition($member,$competition));
                    $upd++;
                } else {
                    if ($remove) {
                        $this->entityManager->remove($enrolment);
                        $rem++;
                    } else {
                        $enrolment->setDisabled(true);
                        $upd++;
                    }
                }
            }
        }

        if ($flush) $this->entityManager->flush();
        $this->exitMessage[] = sprintf('Verified %d erolments: %d updated %d removed.', $all, $upd, $rem);

        return true;
    }

    public function verifyMemberEnrolments(Member $member, bool $update=true, bool $flush=true): ?bool
    {
        $all=0; $add=0; $upd=0;
        foreach ($member->getTeam()->getEnabledCompetitionsFromDate() as $competition) {
            $enrolled = $competition->getRestrictions() ? false : $team->getDefaultEnrolled();
            $disabled = !$this->memberCompliantWithCompetition($member,$competition);
            foreach ($competition->getEnabledCompetitionParts() as $competitionPart) {
                $all++;
                if ($enrolment = $competitionPart->getMemberEnrolment($member)) {
                    if (!$update) continue;
                    $enrolment->setDisabled($disabled);
                    $enrolment->setMember($member); // update team
                    $upd++;
                } else {
                    $enrolment = new CompetitionEnrolment( $competitionPart, $member, $enabled, $disabled );
                    $this->entityManager->persist($enrolment);
                    $add++;
                }
            }
        }

        if ($flush) $this->entityManager->flush();
        $this->exitMessage[] = sprintf('Verified %d enrolments for member %s: %d added %d updated.', $all, $member->getName(), $add, $upd);
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

    public function getExitMessage(): ?array
    {
        return $this->exitMessage;
    }

}
