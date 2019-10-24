<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnrolmentTimeRepository")
 */
class EnrolmentTime
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $startTime;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $endTime;

    /**
     * @ORM\Column(type="dateinterval")
     */
    private $duration;

    /**
     * @ORM\Column(type="boolean")
     */
    private $strictEndTime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalNumberOfPersons;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $maxNumberOfPersons;

    /**
     * @ORM\Column(type="boolean")
     */
    private $strictNumberOfPersonsLimit;

    /**
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Enrolment", mappedBy="time")
     */
    private $enrolments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EnrolmentEvent", inversedBy="times")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    public function __construct()
    {
        $this->duration = new \DateInterval('PT1H');
        $this->strictEndTime = false;
        $this->startTime = new \DateTimeImmutable("today noon");
        $this->totalNumberOfPersons = 0;
        $this->totalPrice = 0.;
        $this->enrolments = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        $t = $this->showDate ? $this->startTime->format('Y-m-d H:i') : $this->startTime->format('H:i');
        return $this->strictEndTime ? $t." - ".$this->endTime->format('H:i') : $t;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        if ($this->isLocked()) return $this;
        $h = (int) $startTime->format('H');
        $m = (int) $startTime->format('i');

        $this->startTime = $this->startTime->setTime($h,$m);
        $this->endTime = $this->startTime->add($this->duration);

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function getDuration(): ?\DateInterval
    {
        return $this->duration;
    }

    public function setDuration(\DateInterval $duration): self
    {
        if ($this->isLocked()) return $this;
        $this->duration = $duration;
        $this->endTime = $this->startTime->add($duration);

        return $this;
    }

    public function getStrictEndTime(): ?bool
    {
        return $this->strictEndTime;
    }

    public function setStrictEndTime(bool $strictEndTime): self
    {
        if ($this->isLocked()) return $this;
        $this->strictEndTime = $strictEndTime;

        return $this;
    }

    public function getShowDate(): ?bool
    {
        return $this->showDate;
    }

    public function setShowDate(bool $showDate): self
    {
        $this->showDate = $showDate;

        return $this;
    }

    public function getTotalNumberOfPersons(): ?int
    {
        return $this->totalNumberOfPersons;
    }

    public function addNumberOfPersons(int $numberOfPersons): self
    {
        $this->totalNumberOfPersons += $numberOfPersons;

        return $this;
    }

    public function getMaxNumberOfPersons(): ?int
    {
        return $this->maxNumberOfPersons;
    }

    public function setMaxNumberOfPersons(int $maxNumberOfPersons): self
    {
        $this->maxNumberOfPersons = $maxNumberOfPersons;

        return $this;
    }

    public function getRemainingNumberOfPersons(): ?int
    {
        return $this->strictNumberOfPersonsLimite ? null : $this->maxNumberOfPersons - $this->totalNumberOfPersons;
    }

    public function getStrictNumberOfPersonsLimit(): ?bool
    {
        return $this->strictNumberOfPersonsLimit;
    }

    public function setStrictNumberOfPersonsLimit(bool $strictNumberOfPersonsLimit): self
    {
        $this->strictNumberOfPersonsLimit = $strictNumberOfPersonsLimit;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function addTotalPrice(int $totalPrice): self
    {
        $this->totalPrice += $totalPrice;

        return $this;
    }

    /**
     * @return Collection|Enrolment[]
     */
    public function getEnrolments(): Collection
    {
        return $this->enrolments;
    }

    public function getNumberOfEnrolments(): ?int
    {
        return count($this->enrolments);
    }

    public function addEnrolment(Enrolment $enrolment): self
    {
        if (!$this->enrolments->contains($enrolment)) {
            $this->enrolments[] = $enrolment;
            $enrolment->setTime($this);
        }

        return $this;
    }

    public function removeEnrolment(Enrolment $enrolment): self
    {
        if ($this->enrolments->contains($enrolment)) {
            $this->enrolments->removeElement($enrolment);
            // set the owning side to null (unless already changed)
            if ($enrolment->getTime() === $this) {
                $enrolment->setTime(null);
            }
        }

        return $this;
    }

    public function getEvent(): ?EnrolmentEvent
    {
        return $this->event;
    }

    public function setEvent(?EnrolmentEvent $event): self
    {
        if ($this->isLocked()) return $this;

        $this->event = $event;
        $this->startTime = \DateTimeImmutable::createFromMutable($event->getCalendar()->getStartTime())->modify('midnight');
        $this->endTime = $this->startTime->add($this->duration);

        return $this;
    }

    public function isLocked(): ?bool
    {
        if (is_null($this->event)) return false;
        return $this->event->getEnabled();
    }

}
