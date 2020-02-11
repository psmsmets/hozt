<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnrolmentEventRepository")
 */
class EnrolmentEvent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $enrolBefore;

    /**
     * @ORM\Column(type="integer")
     */
    private $enrolBeforeDays;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalNumberOfPersons;

    /**
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EnrolmentTime", mappedBy="event")
     */
    private $times;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EnrolmentInput", mappedBy="event")
     */
    private $inputs;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\CalendarEvent", inversedBy="enrolmentEvent")
     */
    private $calendar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $guestAccess;

    /**
     * @ORM\Column(type="boolean")
     */
    private $freeOfCharge;

    /**
     * @ORM\Column(type="boolean")
     */
    private $tas;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Enrolment", mappedBy="event")
     */
    private $enrolments;

    public function __construct()
    {
        $this->enabled = false;
        $this->freeOfCharge = false;
        $this->guestAccess = true;
        $this->tas = true;
        $this->enrolBeforeDays = 7;
        $this->totalNumberOfPersons = 0;
        $this->totalPrice = 0.;
        $this->times = new ArrayCollection();
        $this->inputs = new ArrayCollection();
        $this->enrolments = new ArrayCollection();
        $this->inputCategories = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled, bool $force=false): self
    {
        if ($force) {
            $this->enabled = $enabled;
        } else {
            $this->enabled = $enabled ? $enabled : $this->enabled;
        }

        return $this;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function isDraft(): ?bool
    {
        return !$this->enabled;
    }

    public function getEnrolBefore(): ?\DateTimeInterface
    {
        return $this->enrolBefore;
    }

    private function setEnrolBefore(): self
    {
        $this->enrolBefore = \DateTimeImmutable::createFromMutable($this->calendar->getStartTime())->modify('midnight')->sub(new \DateInterval('P'.$this->enrolBeforeDays.'D'));

        return $this;
    }

    public function getEnrolBeforeDays(): ?int
    {
        return $this->enrolBeforeDays;
    }

    public function setEnrolBeforeDays(int $enrolBeforeDays): self
    {
        $this->enrolBeforeDays = $enrolBeforeDays < 0 ? 0 : $enrolBeforeDays;
        $this->setEnrolBefore();

        return $this;
    }

    public function getNumberOfEnrolments(): ?int
    {
        return count($this->enrolments);
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
     * @return Collection|EnrolmentTime[]
     */
    public function getTimes(): Collection
    {
        return $this->times;
    }

    public function addTime(EnrolmentTime $time): self
    {
        if ($this->enabled) return $this;

        if (!$this->times->contains($time)) {
            $this->times[] = $time;
            $time->setEvent($this);
        }

        return $this;
    }

    public function removeTime(EnrolmentTime $time): self
    {
        if ($this->times->contains($time)) {
            $this->times->removeElement($time);
            // set the owning side to null (unless already changed)
            if ($time->getEvent() === $this) {
                $time->setEvent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|EnrolmentInput[]
     */
    public function getInputs(): Collection
    {
        return $this->inputs;
    }

    public function getNonZeroInputs(): Collection
    {
        $inputs = $this->inputs->filter(function(EnrolmentInput $input){
            return $input->getNumber() > 0;
        });

        $iterator = $inputs->getIterator();
        $iterator->uasort(function (EnrolmentInput $a, EnrolmentInput $b) {
            $ds = $a->getCategory()->getSequence() - $b->getCategory()->getSequence();

            if ($ds > 0) return 1;
            if ($ds < 0) return -1;
            if ($ds == 0) return ($a->getId() > $b->getId()) ? 1 : -1;
        });

        return new ArrayCollection(iterator_to_array($iterator));
    }

    public function addInput(EnrolmentInput $input): self
    {
        if ($this->enabled) return $this;

        if (!$this->inputs->contains($input)) {
            $this->inputs[] = $input;
            $input->setEvent($this);
        }

        return $this;
    }

    public function removeInput(EnrolmentInput $input): self
    {
        if ($this->enabled) return $this;

        if ($this->inputs->contains($input)) {
            $this->inputs->removeElement($input);
            // set the owning side to null (unless already changed)
            if ($input->getEvent() === $this) {
                $input->setEvent(null);
            }
        }

        return $this;
    }

    public function getCalendar(): ?CalendarEvent
    {
        return $this->calendar;
    }

    public function setCalendar(?CalendarEvent $calendar): self
    {
        if ($this->enabled) return $this;

        $this->calendar = $calendar;
        $this->setEnrolBefore();

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->calendar ? $this->calendar->getTitle() : '__draft__';
    }

    public function getTitleYear(string $sep = ' '): ?string
    {
        return $this->calendar ? $this->calendar->getTitle() . $sep . $this->calendar->getStartTime()->format('Y') : '__draft__';
    }

    public function getUuid(): ?string
    {
        return $this->calendar ? $this->calendar->getUuid() : '__draft__';
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        if ($this->enabled) return $this;

        $this->slug = $slug;

        return $this;
    }

    public function hasGuestAccess(): ?bool
    {
        return $this->guestAccess;
    }

    public function getGuestAccess(): ?bool
    {
        return $this->guestAccess;
    }

    public function setGuestAccess(bool $guestAccess): self
    {
        if ($this->enabled) return $this;

        $this->guestAccess = $guestAccess;

        return $this;
    }

    public function getFreeOfCharge(): ?bool
    {
        return $this->freeOfCharge;
    }

    public function setFreeOfCharge(bool $freeOfCharge): self
    {
        if ($this->enabled) return $this;

        $this->freeOfCharge = $freeOfCharge;

        return $this;
    }

    public function isFreeOfCharge(): ?bool
    {
        return $this->freeOfCharge;
    }

    public function getTAS(): ?bool
    {
        return $this->tas;
    }

    public function setTAS(bool $tas): self
    {
        if ($this->enabled) return $this;

        $this->tas = $tas;

        return $this;
    }

    /**
     * @return Collection|Enrolment[]
     */
    public function getEnrolments(): Collection
    {
        return $this->enrolments;
    }

    public function addEnrolment(Enrolment $enrolment): self
    {
        if (!$this->enrolments->contains($enrolment)) {
            $this->enrolments[] = $enrolment;
            $enrolment->setEvent($this);
        }

        return $this;
    }

    public function removeEnrolment(Enrolment $enrolment): self
    {
        if ($this->enrolments->contains($enrolment)) {
            $this->enrolments->removeElement($enrolment);
            // set the owning side to null (unless already changed)
            if ($enrolment->getEvent() === $this) {
                $enrolment->setEvent(null);
            }
        }

        return $this;
    }

}
