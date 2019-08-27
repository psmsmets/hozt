<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionRepository")
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
     * @ORM\Column(type="boolean")
     */
    private $multiDay;

    /**
     * @ORM\Column(type="boolean")
     */
    //private $splitEnrollments;

    /**
     * @ORM\Column(type="boolean")
     */
    private $restrictions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CompetitionPool", inversedBy="competitions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pool;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionDocument", mappedBy="competition")
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionEnrolment", mappedBy="competition")
     */
    private $enrolments;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->multiDay = false;
        $this->teams = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->enrolments = new ArrayCollection();
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

    /**
     * @return Collection|CompetitionEnrolment[]
     */
    public function getEnrolments(): Collection
    {
        return $this->enrolments;
    }

    public function addEnrolment(CompetitionEnrolment $enrolment): self
    {
        if (!$this->enrolments->contains($enrolment)) {
            $this->enrolments[] = $enrolment;
            $enrolment->setCompetition($this);
        }

        return $this;
    }

    public function removeEnrolment(CompetitionEnrolment $enrolment): self
    {
        if ($this->enrolments->contains($enrolment)) {
            $this->enrolments->removeElement($enrolment);
            // set the owning side to null (unless already changed)
            if ($enrolment->getCompetition() === $this) {
                $enrolment->setCompetition(null);
            }
        }

        return $this;
    }

}
