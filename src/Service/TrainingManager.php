<?php

namespace App\Service;

use App\Entity\TrainingSchedule;
use App\Entity\TrainingException;
use App\Repository\TrainingScheduleRepository;
use App\Repository\TrainingExceptionRepository;
use Doctrine\ORM\EntityManagerInterface;

class TrainingManager 
{
    private $em;
    private $scheduleRepository;
    private $exceptionRepository;
    private $exitMessage;

    public function __construct(EntityManagerInterface $em, TrainingScheduleRepository $scheduleRepository, TrainingExceptionRepository $exceptionRepository)
    {
        $this->em = $em;
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

    public function getExitMessage(): ?array
    {
        return $this->exitMessage;
    }

}
