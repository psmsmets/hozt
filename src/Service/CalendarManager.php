<?php

namespace App\Service;

use App\Entity\CalendarEvent;
use App\Repository\CalendarEventRepository;
use Doctrine\ORM\EntityManagerInterface;

class CalendarManager 
{
    private $entityManager;
    private $calendarRepository;
    private $exitMessage;

    public function __construct(EntityManagerInterface $entityManager, CalendarEventRepository $calendarRepository)
    {
        $this->entityManager = $entityManager;
        $this->calendarRepository = $calendarRepository;
        $this->exitMessage = null;
    }

    public function autoArchive(): ?bool
    {
        $events = $this->calendarRepository->findPastCalendarEvents();
        foreach( $events as $event) {
            $event->setArchived(true);
        }
        $this->calendarRepository->flush();
        $this->exitMessage = sprintf('Done. Archived %d events.', sizeof($events));
        return true;
    }

    public function getExitMessage(): ?string
    {
        return $this->exitMessage;
    }

}
