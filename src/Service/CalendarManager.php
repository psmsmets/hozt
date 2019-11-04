<?php

namespace App\Service;

use App\Entity\CalendarEvent;
use App\Repository\CalendarEventRepository;
use Doctrine\ORM\EntityManagerInterface;

class CalendarManager 
{
    private $oneYear;
    private $em;
    private $calendarRepository;
    private $exitMessage;
    private $periodStart;

    public function __construct(EntityManagerInterface $em, CalendarEventRepository $calendarRepository)
    {
        $this->em = $em;
        $this->calendarRepository = $calendarRepository;
        $this->exitMessage = null;
        $this->oneYear = new \DateInterval('P1Y');
        $this->periodStart = $this->calcPeriodStart();
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

    public function yearToPeriodStart(int $year): \DateTimeInterface
    {
        return new \DateTimeImmutable("$year-08-15");
    }

    public function calcPeriodStart(\DateTimeInterface $refdate=null): \DateTimeInterface
    {
        if (is_null($refdate)) $refdate = new \DateTimeImmutable('today');
        $start = new \DateTimeImmutable('15 august this year');

        return $refdate < $start ? $start->sub($this->oneYear) : $start;
    }

    public function getPeriodStart(\DateTimeInterface $refdate=null): \DateTimeInterface
    {
        if (is_null($refdate)) return $this->periodStart;

        return $this->calcPeriodStart($refdate);
    }

    public function getPeriodEnd(\DateTimeInterface $refdate=null): \DateTimeInterface
    {
        if (is_null($refdate)) return $this->periodStart->add($this->oneYear);

        return $this->calcPeriodStart($refdate)->add($this->oneYear);
    }

    public function getExitMessage(): ?string
    {
        return $this->exitMessage;
    }

}
