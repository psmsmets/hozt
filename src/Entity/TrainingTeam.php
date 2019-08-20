<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingTeamRepository")
 */
class TrainingTeam
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=5, unique=true)
     */
    private $abbr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TrainingTeamCategory", inversedBy="teams")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TrainingSchedule", mappedBy="teams")
     */
    private $schedule;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TrainingCoach", mappedBy="teams")
     */
    private $coaches;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Competition", mappedBy="teams")
     */
    private $competitions;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TrainingException", mappedBy="teams")
     */
    private $exceptions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $goal;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $age;

    /**
     * @ORM\Column(type="json_array")
     */
    private $requirements = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Member", mappedBy="team")
     */
    private $members;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionEnrolment", mappedBy="team")
     */
    private $competitionEnrolments;

    /**
     * @ORM\Column(type="boolean")
     */
    private $defaultEnrolled;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->enabled = true;
        $this->coaches = new ArrayCollection();
        $this->competitions = new ArrayCollection();
        $this->schedule = new ArrayCollection();
        $this->exceptions = new ArrayCollection();
        $this->members = new ArrayCollection();
        $this->competitionEnrolments = new ArrayCollection();
        $this->defaultEnrolled = false;
    }

    public function __toString(): ?string
    {
        return $this->abbr;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAbbr(): ?string
    {
        return $this->abbr;
    }

    public function setAbbr(string $abbr): self
    {
        $this->abbr = $abbr;

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

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

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

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getCategory(): ?TrainingTeamCategory
    {
        return $this->category;
    }

    public function setCategory(TrainingTeamCategory $category): self
    {
        $this->category = $category;

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
            $schedule->addTeam($this);
        }

        return $this;
    }

    public function removeSchedule(TrainingSchedule $schedule): self
    {
        if ($this->schedule->contains($schedule)) {
            $this->schedule->removeElement($schedule);
            $schedule->removeTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection|TrainingCoach[]
     */
    public function getCoaches(): Collection
    {
        return $this->coaches;
    }

    public function addCoach(TrainingCoach $coach): self
    {
        if (!$this->coaches->contains($coach)) {
            $this->coaches[] = $coach;
            $coach->addTeam($this);
        }

        return $this;
    }

    public function removeCoach(TrainingCoach $coach): self
    {
        if ($this->coaches->contains($coach)) {
            $this->coaches->removeElement($coach);
            $coach->removeTeam($this);
        }

        return $this;
    }

    /**
     * @return Collection|Competition[]
     */
    public function getCompetitions(): Collection
    {
        return $this->competitions;
    }

    public function addCompetition(Competition $competition): self
    {
        if (!$this->competitions->contains($competition)) {
            $this->competitions[] = $competition;
            $competition->addTeam($this);
        }

        return $this;
    }

    public function removeCompetition(Competition $competition): self
    {
        if ($this->competitions->contains($competition)) {
            $this->competitions->removeElement($competition);
            $competition->removeTeam($this);
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

    public function addException(TrainingException $exception): self
    {
        if (!$this->exceptions->contains($exception)) {
            $this->exceptions[] = $exception;
            $exception->addTeam($this);
        }

        return $this;
    }

    public function removeException(TrainingException $exception): self
    {
        if ($this->exceptions->contains($exception)) {
            $this->exceptions->removeElement($exception);
            $exception->removeTeam($this);
        }

        return $this;
    }

    public function getGoal(): ?string
    {
        return $this->goal;
    }

    public function setGoal(string $goal): self
    {
        $this->goal = $goal;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getRequirements(): ?array
    {
        return $this->requirements;
    }

    public function setRequirements(array $requirements): self
    {
        $this->requirements = $requirements;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setTeam($this);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getTeam() === $this) {
                $member->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CompetitionEnrolment[]
     */
    public function getCompetitionEnrolments(): Collection
    {
        return $this->competitionEnrolments;
    }

    public function addCompetitionEnrolment(CompetitionEnrolment $competitionEnrolment): self
    {
        if (!$this->competitionEnrolments->contains($competitionEnrolment)) {
            $this->competitionEnrolments[] = $competitionEnrolment;
            $competitionEnrolment->setTeam($this);
        }

        return $this;
    }

    public function removeCompetitionEnrolment(CompetitionEnrolment $competitionEnrolment): self
    {
        if ($this->competitionEnrolments->contains($competitionEnrolment)) {
            $this->competitionEnrolments->removeElement($competitionEnrolment);
            // set the owning side to null (unless already changed)
            if ($competitionEnrolment->getTeam() === $this) {
                $competitionEnrolment->setTeam(null);
            }
        }

        return $this;
    }

    public function getDefaultEnrolled(): ?bool
    {
        return $this->defaultEnrolled;
    }

    public function setDefaultEnrolled(bool $defaultEnrolled): self
    {
        $this->defaultEnrolled = $defaultEnrolled;

        return $this;
    }

/*
    public function setCategory(?TrainingTeamCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
*/

}
