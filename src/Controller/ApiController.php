<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
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
use App\Entity\CompetitionDocument;
use App\Entity\CompetitionDocumentCategory;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/traint-{team_abbr}-vandaag", name="api_training_team_today")
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
     * @Route("/api/training/vandaag", name="api_training_today")
     */
    public function training_today()
    {
        $date = new \DateTime('today midnight');
        $day_id = date('N', $date->getTimestamp());

        $schedule = $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findAllByDayJoinedToTeam($day_id,$date)
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
     * @Route("/api/training/morgen", name="api_training_tomorrow")
     */
    public function training_tomorrow()
    {
        $date = new \DateTime('today midnight');
        $date->modify('+1 day');
        $day_id = date('N', $date->getTimestamp());

        $schedule = $this->getDoctrine()
            ->getRepository(TrainingSchedule::class)
            ->findAllByDayJoinedToTeam($day_id,$date)
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
     * @Route("/api/training/{team_abbr}", name="api_training_team")
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
     * @Route("/api/kalender/aanstaande/{count}", name="api_calender_events")
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
                   'cancelled' => $event->getCancelled(),
                   'uuid' => $event->getUuid(),
                   'url' => $this->get('router')->generate('calendar_event', array('uuid' => $event->getUuid())),
               );
        }
        return $this->json(array( 'result' => true, 'data' => $data ));
    }

    /**
     * @Route("/api/documenten/wedstrijden/aanstaande/{slug}/{limit}", name="api_documents_competition_upcoming")
     */
    public function documents_competition_upcoming(string $slug, int $limit=5)
    {
        $docs = $this->getDoctrine()
            ->getRepository(CompetitionDocument::class)
            ->findUpcomingCompetitionDocuments($slug,$limit)
            ;

        if (!$docs) {
            return $this->json(array('result'=>false,'error'=>"Geen documenten gevonden."));
        }
        $data = array();
        $base = $this->getParameter('app.path.competition_documents');
        foreach ( $docs as $doc ) {
           $event = $doc->getCompetition()->getCalendar();
           $data[] = array(
                   'title' => (is_null($doc->getDescription())) ? $event->getTitle() : $event->getTitle() . " - " . $doc->getDescription(),
                   'date' => $event->getStartTime()->format('Y-m-d'),
                   'datestr' =>  strftime("%e %b", $event->getStartTime()->getTimestamp()),
                   'location' => $event->getLocation(),
                   'doc' => (is_null($doc->getDocument())) ? $doc->getUrl() : $base.'/'.$doc->getDocument(),
               );
        }
        return $this->json(array( 
                'result' => true, 
                'category' => $doc->getCategory()->getTitle(), 
                'type' => 'upcoming', 
                'data' => $data,
            ));
    }

    /**
     * @Route("/api/documenten/wedstrijden/laatste/{slug}/{limit}", name="api_documents_competition_latest")
     */
    public function documents_competition_latest(string $slug, int $limit=5)
    {
        $docs = $this->getDoctrine()
            ->getRepository(CompetitionDocument::class)
            ->findLatestCompetitionDocuments($slug,$limit)
            ;

        if (!$docs) {
            return $this->json(array('result'=>false,'error'=>"Geen documenten gevonden."));
        }
        $data = array();
        $base = $this->getParameter('app.path.competition_documents');
        foreach ( $docs as $doc ) {
           $event = $doc->getCompetition()->getCalendar();
           $data[] = array(
                   'title' => (is_null($doc->getDescription())) ? $event->getTitle() : $event->getTitle() . " - " . $doc->getDescription(),
                   'date' => $event->getStartTime()->format('Y-m-d'),
                   'datestr' =>  strftime("%e %b", $event->getStartTime()->getTimestamp()),
                   'location' => $event->getLocation(),
                   'doc' => (is_null($doc->getDocument())) ? $doc->getUrl() : $base.'/'.$doc->getDocument(),
               );
        }
        return $this->json(array( 
                'result' => true, 
                'category' => $doc->getCategory()->getTitle(), 
                'type' => 'latest', 
                'data' => $data,
            ));
    }

}
