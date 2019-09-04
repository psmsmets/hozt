<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrainingTeamCategoryRepository")
 */
class TrainingTeamCategory
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
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $times;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $days = [];

    /**
     * @ORM\Column(type="integer")
     */
    private $sequence;

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
     * @ORM\OneToMany(targetEntity="App\Entity\TrainingTeam", mappedBy="category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teams;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TryoutEnrolment", mappedBy="category")
     */
    private $tryoutEnrolments;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->enabled = true;
        $this->teams = new ArrayCollection();
        $this->tryoutEnrolments = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

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

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getTimes(): ?string
    {
        return $this->times;
    }

    public function setTimes(string $times): self
    {
        $this->times = $times;

        return $this;
    }

    public function getDays(): ?array
    {
        return $this->days;
    }

    public function setDays(array $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): self
    {
        $this->sequence = $sequence;

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

    /**
     * @return Collection|TrainingTeam[]
     */
    public function getTeams(bool $enabled = null): Collection
    {
        if (is_null($enabled)) return $this->teams;
        return $this->teams->filter(
            function(TrainingTeam $team) use ($enabled) {
                return $team->getEnabled() === $enabled;
            }
        );
    }

    /**
     * @return Collection|TryoutEnrolment[]
     */
    public function getTryoutEnrolments(): Collection
    {
        return $this->tryoutEnrolments;
    }

    public function addTryoutEnrolment(TryoutEnrolment $tryoutEnrolment): self
    {
        if (!$this->tryoutEnrolments->contains($tryoutEnrolment)) {
            $this->tryoutEnrolments[] = $tryoutEnrolment;
            $tryoutEnrolment->setCategory($this);
        }

        return $this;
    }

    public function removeTryoutEnrolment(TryoutEnrolment $tryoutEnrolment): self
    {
        if ($this->tryoutEnrolments->contains($tryoutEnrolment)) {
            $this->tryoutEnrolments->removeElement($tryoutEnrolment);
            // set the owning side to null (unless already changed)
            if ($tryoutEnrolment->getCategory() === $this) {
                $tryoutEnrolment->setCategory(null);
            }
        }

        return $this;
    }

/*
    public function addTrainingTeam(TrainingTeam $trainingTeam): self
    {
        if (!$this->teams->contains($trainingTeam)) {
            $this->teams[] = $trainingTeam;
            $trainingTeam->setCategory($this);
        }

        return $this;
    }
*/

/*
    public function removeTrainingTeam(TrainingTeam $trainingTeam): self
    {
        if ($this->teams->contains($trainingTeam)) {
            $this->teams->removeElement($trainingTeam);
            // set the owning side to null (unless already changed)
            if ($trainingTeam->getCategory() === $this) {
                $trainingTeam->setCategory(null);
            }
        }

        return $this;
    }
*/

}
