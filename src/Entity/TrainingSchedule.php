<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingScheduleRepository")
 */
class TrainingSchedule
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $dressingRoom;

    /**
     * @ORM\Column(type="smallint")
     */
    private $dayNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TrainingTime", inversedBy="schedule")
     * @ORM\JoinColumn(nullable=false)
     */
    private $time;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TrainingTeam", inversedBy="schedule")
     */
    private $teams;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TrainingException", mappedBy="schedule")
     */
    private $exceptions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $persistent;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->startDate = $this->createdAt;
        $this->endDate = $this->createdAt;
        $this->persistent = true;
        $this->teams = new ArrayCollection();
        $this->exceptions = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->getDayName()." ".strval($this->getTime());
    }

    public function getFormat(): ?string
    {
        return $this->dayNumber." ".$this->getDayName()." ".strval($this->getTime());
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDressingRoom(): ?string
    {
        return $this->dressingRoom;
    }

    public function setDressingRoom(?string $dressingRoom): self
    {
        $this->dressingRoom = $dressingRoom;

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

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getDayNumber(): ?int
    {
        return $this->dayNumber;
    }

    public function setDayNumber(int $dayNumber): self
    {
        $this->dayNumber = $dayNumber;

        return $this;
    }

    public function getDayName(int $trim = null): ?string
    {
        $dayName = jddayofweek($this->dayNumber-1,$mode=1);
        return $trim ? substr($dayName,0,$trim) : $dayName;
    }

    public function getTime(): ?TrainingTime
    {
        return $this->time;
    }

    public function setTime(?TrainingTime $time): self
    {
        $this->time = $time;

        return $this;
    }

    /**
     * @return Collection|TrainingTeam[]
     */
    public function getTeams(TrainingTeamCategory $category = null): Collection
    {
        if (is_null($category)) return $this->teams;
        return $this->teams->filter(
            function(TrainingTeam $team) use ($category) {
                return $team->getCategory() === $category;
                //return $team->getCategory() == $category;
            }
        );
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

    /**
     * @return Collection|TrainingException[]
     */
    public function getExceptions(): Collection
    {
        return $this->exceptions;
    }

    public function getActiveExceptions(\DateTimeInterface $refdate = null): Collection
    {
        if (is_null($refdate)) $refdate = new \DateTimeImmutable('today midnight');
        return $this->getExceptions()->filter(
            function(TrainingException $ex) use ($refdate) { 
                return $ex->isActive($refdate); 
            }
        );
    }

    public function addException(TrainingException $exception): self
    {
        if (!$this->exceptions->contains($exception)) {
            $this->exceptions[] = $exception;
            $exception->addSchedule($this);
        }

        return $this;
    }

    public function removeException(TrainingException $exception): self
    {
        if ($this->exceptions->contains($exception)) {
            $this->exceptions->removeElement($exception);
            $exception->removeSchedule($this);
        }

        return $this;
    }

    public function getPersistent(): ?bool
    {
        return $this->persistent;
    }

    public function setPersistent(bool $persistent): self
    {
        $this->persistent = $persistent;

        return $this;
    }

    public function getRegular(): ?bool
    {
        return !$this->persistent;
    }

    public function setRegular(bool $regular): self
    {
        $this->persistent = !$regular;

        return $this;
    }

    public function isActiveOnDay(\DateTimeInterface $refdate): bool
    {
        if (is_null($refdate)) $refdate = new \DateTimeImmutable('today midnight');
        return (
                $this->getStartDate() <= $reftime and
                ( $this->getEndDate() >= $reftime or is_null($this->getEndDate()) ) and
                $this->getDayNumber() == date('N', $refdate->getTimestamp())
             );
    }

    public function isActive(\DateTimeInterface $start, \DateTimeInterface $end, array $days): bool
    {
        return (
                $this->getStartDate() <= $start and
                ( $this->getEndDate() >= $end or is_null($this->getEndDate()) ) and
                in_array( $this->getDayNumber(), $days )
             );
    }

}
