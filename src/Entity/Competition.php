<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionRepository")
 * @Vich\Uploadable
 */
class Competition
{
    /**
     * Parameters
     */
    const MULTI_DAY = false;
    const SHOW_UPDATED_AT = false;

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
     * @ORM\OneToOne(targetEntity="App\Entity\CalendarEvent", inversedBy="competition", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $calendar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TrainingTeam", inversedBy="competitions")
     */
    private $teams;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\TrainingTeamCategory", inversedBy="competitions")
     */
    private $teamCategories;

    /**
     * @ORM\Column(type="boolean")
     */
    private $multiDay;

    /**
     * @ORM\Column(type="boolean")
     */
    private $restrictions;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $warmupTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $preprogram;

    /**
     * @Vich\UploadableField(mapping="competition_preprograms", fileNameProperty="preprogram")
     * @var File
     */
    private $preprogramFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $program;

    /**
     * @Vich\UploadableField(mapping="competition_programs", fileNameProperty="program")
     * @var File
     */
    private $programFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $results;

    /**
     * @Vich\UploadableField(mapping="competition_results", fileNameProperty="results")
     * @var File
     */
    private $resultsFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CompetitionState", inversedBy="competitions")
     */
    private $state;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->multiDay = Competition::MULTI_DAY;
        $this->teams = new ArrayCollection();
        $this->teamCategories = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->id;
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

    public function getCalendar(): ?CalendarEvent
    {
        return $this->calendar;
    }

    public function setCalendar(CalendarEvent $calendar): self
    {
        $this->calendar = $calendar;

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

    /**
     * @return Collection|TrainingTeamCategory[]
     */
    public function getTeamCategories(): Collection
    {
        return $this->teamCategories;
    }

    public function addTeamCategory(TrainingTeamCategory $teamCategory): self
    {
        if (!$this->teamCategories->contains($teamCategory)) {
            $this->teamCategories[] = $teamCategory;
        }

        return $this;
    }

    public function removeTeamCategory(TrainingTeamCategory $teamCategory): self
    {
        if ($this->teamCategories->contains($teamCategory)) {
            $this->teamCategories->removeElement($teamCategory);
        }

        return $this;
    }

    public function getMultiDay(): ?bool
    {
        return $this->multiDay;
    }

    public function setMultiDay(bool $multiDay): self
    {
        $this->multiDay = $multiDay;

        return $this;
    }

    public function getRestrictions(): ?bool
    {
        return $this->restrictions;
    }

    public function setRestrictions(bool $restrictions): self
    {
        $this->restrictions = $restrictions;

        return $this;
    }

    public function getWarmupTime(): ?\DateTimeInterface
    {
        return $this->warmupTime;
    }

    public function setWarmupTime(?\DateTimeInterface $warmupTime): self
    {
        $this->warmupTime = $warmupTime;

        return $this;
    }

    public function getPreprogram(): ?string
    {
        return $this->preprogram;
    }

    public function setPreprogram(?string $preprogram): self
    {
        $this->preprogram = $preprogram;

        return $this;
    }

    public function setPreprogramFile(File $file = null)
    {
        $this->preprogramFile = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getPreprogramFile()
    {
        return $this->preprogramFile;
    }

    public function getProgram(): ?string
    {
        return $this->program;
    }

    public function setProgram(?string $program): self
    {
        $this->program = $program;

        return $this;
    }

    public function setProgramFile(File $file = null)
    {
        $this->programFile = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getProgramFile()
    {
        return $this->programFile;
    }

    public function getResults(): ?string
    {
        return $this->results;
    }

    public function setResults(?string $results): self
    {
        $this->results = $results;

        return $this;
    }

    public function setResultsFile(File $file = null)
    {
        $this->resultsFile = $file;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($file) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getResultsFile()
    {
        return $this->resultsFile;
    }

    public function getState(): ?CompetitionState
    {
        return $this->state;
    }

    public function setState(?CompetitionState $state): self
    {
        $this->state = $state;

        return $this;
    }

}
