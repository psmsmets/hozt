<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingTimeRepository")
 */
class TrainingTime
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $startTime;

    /**
     * @ORM\Column(type="dateinterval")
     */
    private $duration;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TrainingSchedule", mappedBy="time")
     */
    private $schedule;

    public function __construct()
    {
        $this->startTime = new \DateTime("today noon");
        $this->duration = new \DateInterval("+P00Y00M00DT01H00M00S");
        $this->schedule = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->getFormattedPeriod();
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
        $this->startTime = $startTime;

        return $this;
    }

    public function getDuration(): ?\DateInterval
    {
        return $this->duration;
    }

    public function setDuration(\DateInterval $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return (clone $this->getStartTime())->add($this->duration);
    }

    public function getFormattedPeriod(string $separator = '-'): ?string
    {
        return $this->getStartTime()->format('H:i')." $separator ".$this->getEndTime()->format('H:i');
    }

    /**
     * @return Collection|TrainingSchedule[]
     */
    public function getSchedule(): Collection
    {
        return $this->schedule;
    }
}
