<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingExceptionRepository")
 */
class TrainingException
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
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TrainingSchedule", inversedBy="exceptions")
     */
    private $schedule;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TrainingTeam", inversedBy="exceptions")
     */
    private $teams;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->startDate = $this->createdAt;
        $this->endDate = $this->createdAt;
        $this->enabled = true;
        $this->schedule = new ArrayCollection();
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTime("now");

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * @return Collection|TrainingSchedule[]
     */
    public function getSchedule(): Collection
    {
        return $this->schedule;
    }

    public function addSchedule(TrainingSchedule $schedule): self
    {
        if (!$this->schedule->contains($schedule)) {
            $this->schedule[] = $schedule;
        }

        return $this;
    }

    public function removeSchedule(TrainingSchedule $schedule): self
    {
        if ($this->schedule->contains($schedule)) {
            $this->schedule->removeElement($schedule);
        }

        return $this;
    }

    /**
     * @return Collection|TrainingTeam[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(TrainingTeam $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(TrainingTeam $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
        }

        return $this;
    }

    public function calcEndDate(): \DateTime
    {
        $end = clone $this->getEndDate();

        return $end->setTime(23,59,59);
    }

    public function getInterval(): \DateInterval
    {
        return \DateInterval::createFromDateString('1 day');
    }

    public function getPeriod(): \DatePeriod
    {
        return new \DatePeriod($this->getStartDate(), $this->getInterval(), $this->calcEndDate());
    }

    public function getDays(): array
    {
        $days = array();

        foreach ($this->getPeriod() as $dt) {

            $day_id = intval($dt->format('w'));
            if ( $day_id == 0 ) $day_id = 7;
            $days[] = $day_id;

        }

        return array_unique($days);
    }

}
