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
     * @ORM\ManyToOne(targetEntity="App\Entity\CompetitionPool", inversedBy="competitions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pool;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionDocument", mappedBy="competition")
     */
    private $documents;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->multiDay = false;
        $this->teams = new ArrayCollection();
        $this->teamCategories = new ArrayCollection();
        $this->documents = new ArrayCollection();
    }

    public function __toString(): string
    {
        return strval($this->calendar);
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

    public function getPool(): ?CompetitionPool
    {
        return $this->pool;
    }

    public function setPool(?CompetitionPool $pool): self
    {
        $this->pool = $pool;

        return $this;
    }

    /**
     * @return Collection|CompetitionDocument[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(CompetitionDocument $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setCompetition($this);
        }

        return $this;
    }

    public function removeDocument(CompetitionDocument $document): self
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getCompetition() === $this) {
                $document->setCompetition(null);
            }
        }

        return $this;
    }

    public function documentsContainSequence(int $sequence): bool 
    {
        foreach ($this->documents as $doc) {
            if ($doc->getCategory()->getSequence() == $sequence) return true;
        }
    }

    public function documentsContainSlug(string $slug): bool 
    {
        foreach ($this->documents as $doc) {
            if ($doc->getCategory()->getSlug() == $slug) return true;
        }
        return false;
    }

    public function getDocumentsBySequence(int $sequence): Collection
    {
        return $this->getDocuments()->filter(function(CompetitionDocument $document) use($sequence) {
            return $document->getCategory()->getSequence() == $sequence;
        });
    }

    public function getDocumentsBySlug(string $slug): Collection
    {
        return $this->getDocuments()->filter(function(CompetitionDocument $document) use($slug) {
            return $document->getCategory()->getSlug() == $slug;
        });
    }

}
