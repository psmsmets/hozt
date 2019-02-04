<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
/*
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
*/
use App\Entity\TrainingTeam;
use App\Entity\TrainingTeamCategory;
use App\Entity\TrainingSchedule;
use App\Entity\CalendarEvent;
use App\Entity\CalendarCategory;
use App\Entity\Competition;
use App\Entity\CompetitionState;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/traint-{team_abbr}-vandaag", name="training_team_today")
     */
    public function training_team_today(string $team_abbr)
    {
        $schedule = $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findAllByTeamJoinedToTeam($team_abbr)
            ;

        if (!$schedule) {
            return $this->json(array( 'result' => false, 'error' => 'Zwemgroep '.strtoupper($team_abbr).' niet gevonden.' ));
        }

        $day_id = date('N', strtotime(date("Y-m-d")));

        $schedule = array_filter( $schedule, 
            function($item) use($day_id)
            {
                return $item->getDay()->getId() == $day_id;
            }
        );

        $msg = strtoupper($team_abbr).' heeft vandaag ';

        if ( count($schedule) > 0 )
        {
            $msg.='training van';
            $cnt=0;
            foreach ( $schedule as $training )
            {
                if ($cnt==0) { 
                    $msg.=' '.$training->getTime();
                } else {
                    $msg.=' en van '.$training->getTime();
                }
                $cnt++;
            }
            return $this->json(array( 'result' => true, 'message' => $msg));
        } else {
            return $this->json(array( 'result' => false, 'message' => $msg.'geen training.'));
        }

    }

    /**
     * @Route("/api/training/vandaag", name="training_today")
     */
    public function training_today()
    {
        $day_id = date('N', strtotime(date("Y-m-d")));

        $schedule = $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findAllByDayJoinedToTeam($day_id)
            ;

        if (!$schedule) {
            return $this->json(array('result'=>false,'error'=>'Er is vandaag geen training.'));
        } else {
            $data = array();
            foreach ($schedule as $training) {
                $teams = array();
                foreach ( $training->getTeams() as $team ) {
                    $teams[] = array ('abbr' => $team->getAbbr(), 'name' => $team->getName() );
                }
                $data[] = array( 'time' => strval($training->getTime()), 'comment' => $training->getComment(), 'teams' => $teams );

            }
            return $this->json(array('result'=>true,'data'=>$data));
        }

    }

    /**
     * @Route("/api/training/morgen", name="training_tomorrow")
     */
    public function training_tomorrow()
    {
        $day_id = date('N', strtotime(date("Y-m-d").'+1 day'));

        $schedule = $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findAllByDayJoinedToTeam($day_id)
            ;

        if (!$schedule) {
            return $this->json(array('result'=>false,'error'=>'Er is vandaag geen training.'));
        } else {
            $data = array();
            foreach ($schedule as $training) {
                $teams = array();
                foreach ( $training->getTeams() as $team ) {
                    $teams[] = array ('abbr' => $team->getAbbr(), 'name' => $team->getName() );
                }
                $data[] = array( 'time' => strval($training->getTime()), 'comment' => $training->getComment(), 'teams' => $teams );

            }
            return $this->json(array('result'=>true,'data'=>$data));
        }

    }

    /**
     * @Route("/api/training/{team_abbr}", name="training_team")
     */
    public function training_team($team_abbr)
    {
        $team = $this->getDoctrine()
            ->getRepository(TrainingTeam::class)
            ->findOneBy(
                ['enabled' => true, 'abbr' => $team_abbr  ]
            );

        if (!$team) {
            return $this->json(array( 'result' => false, 'error' => 'Zwemgroep '.strtoupper($team_abbr).' niet gevonden.' ));
        }

        $training = $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findTrainingScheduleByTeam($team->getId());

        if (!$training)
        {
            return $this->json(array('result'=>false,'error'=>'Geen trainingen gevonden.'));
        }

        $tmp = array(); // todo: make serializer!

        foreach ($training as $t)
        {
            $key = strval($t->getDay());
            $val = array( "time" => strval($t->getTime()), "comment" => $t->getComment());
            if (!isset($tmp[$key])) {
                $tmp[$key] = array();
            }
            $tmp[$key][] = $val;
        }
        return $this->json(array('result'=>true,'data'=>$tmp));

    }

    /**
     * @Route("/api/kalender/aanstaande/{count}", name="calender_events")
     */
    public function calender_events(int $limit=7)
    {
        $events = $this->getDoctrine()
            ->getRepository(CalendarEvent::class)
            ->findUpcomingCalendarEvents($limit)
            ;
        if (!$events) {
            return $this->json(array( 'result' => true, 'data' => [] ));
        }

        $data = array();
        foreach ( $events as $event ) {
           $data[] = array(
                   'title' => ucfirst($event->getTitle()),
                   'day' => $event->getStartTime()->format('d'),
                   'month' => strftime("%b", $event->getStartTime()->getTimestamp()),
                   'formattedPeriod' => $event->getFormattedPeriod(),
                   'location' => ucfirst($event->getLocation()),
                   'class' => 'cal-'.strval($event->getCategory()->getSequence()),
               );
        }
        return $this->json(array( 'result' => true, 'data' => $data ));
    }

    /**
     * @Route("/api/wedstrijden/programmas", name="competition_programs")
     */
    public function competition_programs(int $limit=3)
    {
        $programs = $this->getDoctrine()
            ->getRepository(Competition::class)
            ->findUpcomingCompetitionPrograms($limit)
            ;

        if (!$programs) {
            return $this->json(array('result'=>false,'error'=>"Geen programma's gevonden."));
        }
        $data = array();
        $base = $this->getParameter('app.path.competition_programs');
        foreach ( $programs as $program ) {
           $data[] = array(
                   'title' => $program->getCalendar()->getTitle(),
                   'date' => $program->getCalendar()->getStartTime()->format('Y-m-d'),
                   'location' => $program->getCalendar()->getLocation(),
                   'program' => $base.'/'.$program->getProgram(),
               );
        }
        return $this->json(array( 'result' => true, 'data' => $data ));
    }

    /**
     * @Route("/api/wedstrijden/uitslagen", name="competition_results")
     */
    public function competition_results(int $limit=3)
    {
        $results = $this->getDoctrine()
            ->getRepository(Competition::class)
            ->findLatestCompetitionResults($limit)
            ;

        if (!$results) {
            return $this->json(array('result'=>false,'error'=>"Geen uitslagen gevonden."));
        }
        $data = array();
        $base = $this->getParameter('app.path.competition_results');
        foreach ( $results as $result ) {
           $data[] = array(
                   'title' => $result->getCalendar()->getTitle(),
                   'date' => $result->getCalendar()->getStartTime()->format('Y-m-d'),
                   'location' => $result->getCalendar()->getLocation(),
                   'results' => $base.'/'.$result->getResults(),
               );
        }
        return $this->json(array( 'result' => true, 'data' => $data ));
    }

}
