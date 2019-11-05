<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\TrainingTeam;
use App\Entity\TrainingSchedule;
use App\Entity\TrainingException;
use App\Repository\TrainingScheduleRepository;
use App\Repository\TrainingExceptionRepository;
use Doctrine\ORM\EntityManagerInterface;

use Twig\Environment;

class ScheduleManager 
{
    private $em;
    private $twig;
    private $scheduleRepository;
    private $exceptionRepository;
    private $exitMessage;

    public function __construct(EntityManagerInterface $em, TrainingScheduleRepository $scheduleRepository, TrainingExceptionRepository $exceptionRepository, Environment $twig)
    {
        $this->em = $em;
        $this->twig = $twig;
        $this->scheduleRepository = $scheduleRepository;
        $this->exceptionRepository = $exceptionRepository;
        $this->exitMessage = array();
    }

    public function autoArchive(): ?bool
    {
/*
        $events = $this->calendarRepository->findPastCalendarEvents();
        foreach( $events as $event) {
            $event->setArchived(true);
        }
        $this->em->flush();
        $this->exitMessage[] = array( 'alert' => 'success', 'html' => sprintf('Removed %d/%d documents.', $cnt_rem, $cnt_doc) );
*/
        return true;
    }

    public function daySchedule(\DateTimeImmutable $refdate, array $filter_teams = null, User $user = null, bool $serialize = false): array 
    {
        $schedule = array(
            'date' => $refdate,
            'schedule' => $this->filterSchedule(
                $this->scheduleRepository->findAllOnDate( $refdate, $filter_teams, $user ),
                $this->exceptionRepository->findAllOnDate( $refdate, $filter_teams, $user ),
                $refdate
            )
        );
        return $serialize ? $this->serializeSchedule($schedule) : $schedule ;
    }

    public function weekSchedule(\DateTimeImmutable $startOfWeek, array $filter_teams = null, User $user = null,  bool $serialize = false): array
    {
        $schedule = array();
        for ($day = 0; $day < 7; $day++) {
            $schedule[$day] = $this->daySchedule( $startOfWeek->modify($day.' days'), $filter_teams, $user, $serialize );
        }
        return $schedule;
    }

    public function serializeSchedule(array $schedule): array
    {
        $data = [];
        foreach( $schedule['schedule'] as $training ) 
        {
            $teamData = [];
            foreach ( $training->getTeams() as $team ) {
                $teamData[] = array ('abbr' => $team->getAbbr(), 'name' => $team->getName() );
            }
            $data[] = array( 
                'time' => strval($training->getTime()),
                'comment' => $training->getComment(), 
                'teams' => $teamData,
            );
        }
        return array(
            'date' => $schedule['date'],
            'localizeddate' => $this->twig->render('easy_admin/localizeddate_full.html.twig', ['value' => $schedule['date']]),
            'schedule' => $data
        );
    }

    private function filterSchedule(array $schedule, array $exceptions, \DateTimeInterface $refdate): array 
    {
        return array_filter($schedule,
            function(TrainingSchedule $training) use ($refdate)
            {
                $exceptions = $training->getActiveExceptions($refdate);
                $teams = $training->getTeams()->filter(
                    function(TrainingTeam $team) use ($refdate, $exceptions)
                    {

                        if (count($team->getActiveExceptions($refdate, true)) > 0) return false; // all day exception(s)

                        if (count($exceptions)>0) {
                            $teamsExs = $team->getExceptions();
                            foreach ($exceptions as $ex) {
                                if ($teamsExs->contains($ex)) return false;
                            }
                        }
                        return true; // keep if no exceptions
                    }
                );
                return count($teams)>0;
            }
        );
    }

    public function getExitMessage(): ?array
    {
        return $this->exitMessage;
    }

}
