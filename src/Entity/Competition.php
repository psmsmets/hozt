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
    private $overnight;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CompetitionPool", inversedBy="competitions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pool;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $organization;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionDocument", mappedBy="competition")
     */
    private $documents;

    /**
     * @ORM\Column(type="boolean")
     */
    private $filtersUpToDate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $restrictions;

    /**
     * @ORM\Column(type="boolean")
     */
    private $registrationId;

    /**
     * @ORM\Column(type="boolean")
     */
    private $similarGenderAgeLimits;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $maleAgeMin;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $maleAgeMax;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $femaleAgeMin;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $femaleAgeMax;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionPart", mappedBy="competition", orphanRemoval=true)
     */
    private $competitionParts;

    /**
     * @ORM\Column(type="smallint")
     */
    private $enrolBeforeDays;

    /**
     * Virtual variable
     */
    private $enrolBefore;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $enrolFrom;

    /**
     * Virtual variables
     */
    private $reapplyFilters = false;
    private $partList = [];
    private $updatePartList = false;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->enrolFrom = null;
        $this->enrolBeforeDays = 21;
        $this->filtersUpToDate = true;
        $this->overnight = false;
        $this->registrationId = true;
        $this->similarGenderAgeLimits = true;
        $this->teams = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->competitionParts = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf('%s %s', $this->calendar->getStartTime()->format('Y-m-d'), $this->calendar->getLocation());
    }

    public function getName(): string
    {
        return $this->calendar->getTitle();
    }

    public function getLocation(): string
    {
        return $this->calendar->getLocation();
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

    public function getCancelled(): bool
    {
        return $this->calendar->getCancelled();
    }

    public function getArchived(): bool
    {
        return $this->calendar->getArchived();
    }

    public function getOvernight(): ?bool
    {
        return $this->overnight;
    }

    public function setOvernight(bool $overnight): self
    {
        $this->overnight = $overnight;

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

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(?string $organization): self
    {
        $this->organization = $organization;

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

    public function getFiltersUpToDate(): ?bool
    {
        return $this->filtersUpToDate;
    }

    public function setFiltersUpToDate(bool $filtersUpToDate): self
    {
        $this->filtersUpToDate = $filtersUpToDate;

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
            $this->filtersUpToDate = false;
        }

        return $this;
    }

    public function removeTeam(TrainingTeam $team): self
    {
        if ($this->teams->contains($team)) {
            $this->teams->removeElement($team);
            $this->filtersUpToDate = false;
        }

        return $this;
    }

    public function getRestrictions(): ?bool
    {
        return $this->restrictions;
    }

    public function setRestrictions(bool $restrictions): self
    {
        if ($restrictions != $this->restrictions) $this->filtersUpToDate = false;
        $this->restrictions = $restrictions;

        return $this;
    }

    public function getRegistrationId(): ?bool
    {
        return $this->registrationId;
    }

    public function setRegistrationId(bool $registrationId): self
    {
        if ($registrationId != $this->registrationId) $this->filtersUpToDate = false;
        $this->registrationId = $registrationId;

        return $this;
    }

    public function getNoRegistrationId(): ?bool
    {
        return !$this->registrationId;
    }

    public function setNoRegistrationId(bool $noRegistrationId): self
    {
        $this->setRegistrationId(!$noRegistrationId);

        return $this;
    }

    public function getSimilarGenderAgeLimits(): ?bool
    {
        return $this->similarGenderAgeLimits;
    }

    public function setSimilarGenderAgeLimits(bool $similarGenderAgeLimits): self
    {
        if ($similarGenderAgeLimits != $this->similarGenderAgeLimits) $this->filtersUpToDate = false;
        $this->similarGenderAgeLimits = $similarGenderAgeLimits;

        return $this;
    }

    public function duplicateGenderAgeLimits(): self
    {
        $this->femaleAgeMin = $this->maleAgeMin;
        $this->femaleAgeMax = $this->maleAgeMax;

        return $this;
    }

    public function getSplitGenderAgeLimits(): ?bool
    {
        return !$this->similarGenderAgeLimits;
    }

    public function setSplitGenderAgeLimits(bool $splitGenderAgeLimits): self
    {
        $this->setSimilarGenderAgeLimits(!$splitGenderAgeLimits);

        return $this;
    }

    public function getMaleAgeMin(): ?int
    {
        return $this->maleAgeMin;
    }

    public function setMaleAgeMin(?int $maleAgeMin): self
    {
        if ($maleAgeMin != $this->maleAgeMin) $this->filtersUpToDate = false;
        $this->maleAgeMin = $maleAgeMin;

        return $this;
    }

    public function getMaleAgeMax(): ?int
    {
        return $this->maleAgeMax;
    }

    public function setMaleAgeMax(?int $maleAgeMax): self
    {
        if ($maleAgeMax != $this->maleAgeMax) $this->filtersUpToDate = false;
        $this->maleAgeMax = $maleAgeMax;

        return $this;
    }

    public function getFemaleAgeMin(): ?int
    {
        return $this->femaleAgeMin;
    }

    public function setFemaleAgeMin(?int $femaleAgeMin): self
    {
        if ($femaleAgeMin != $this->femaleAgeMin) $this->filtersUpToDate = false;
        $this->femaleAgeMin = $femaleAgeMin;

        return $this;
    }

    public function getFemaleAgeMax(): ?int
    {
        return $this->femaleAgeMax;
    }

    public function setFemaleAgeMax(?int $femaleAgeMax): self
    {
        if ($femaleAgeMax != $this->femaleAgeMax) $this->filtersUpToDate = false;
        $this->femaleAgeMax = $femaleAgeMax;

        return $this;
    }

    /**
     * @return Collection|CompetitionPart[]
     */
    public function getCompetitionParts(): Collection
    {
        return $this->competitionParts;
    }

    public function getActiveCompetitionParts(): Collection
    {
        return $this->competitionParts->filter(function(CompetitionPart $competitionPart) {
            return $competitionPart->isActive();
        });
    }

    public function addCompetitionPart(CompetitionPart $competitionPart): self
    {
        if (!$this->competitionParts->contains($competitionPart)) {
            $this->competitionParts[] = $competitionPart;
            $competitionPart->setCompetition($this);
        }

        return $this;
    }

    public function removeCompetitionPart(CompetitionPart $competitionPart): self
    {
        if ($this->competitionParts->contains($competitionPart)) {
            $this->competitionParts->removeElement($competitionPart);
            // set the owning side to null (unless already changed)
            if ($competitionPart->getCompetition() === $this) {
                $competitionPart->setCompetition(null);
            }
        }

        return $this;
    }

    public function getFirstDayCompetitionParts(): ?\DateTimeInterface
    {
        $nofCompetitionParts = count($this->competitionParts);
        if ($nofCompetitionParts==0) return null;
        $day = $this->competitionParts[0]->getDay();
        for ($i=1; $i < $nofCompetitionParts; $i++) {
            if ($this->competitionParts[$i]->getDay() < $day) $day = $this->competitionParts[$i]->getDay();
        }
        return $day;
    }

    public function getLastDayCompetitionParts(): ?\DateTimeInterface
    {
        $nofCompetitionParts = count($this->competitionParts);
        if ($nofCompetitionParts==0) return null;
        $day = $this->competitionParts[0]->getDay();
        for ($i=1; $i < $nofCompetitionParts; $i++) {
            if ($this->competitionParts[$i]->getDay() > $day) $day = $this->competitionParts[$i]->getDay();
        }
        return $day;
    }

    public function getReapplyFilters(): bool
    {
        return $this->reapplyFilters;
    }

    public function setReapplyFilters(bool $reapply): self
    {
        $this->reapplyFilters = $reapply;
        return $this;
    }

    public function getUpdatePartList(): bool
    {
        return $this->updatePartList;
    }

    public function setUpdatePartList(bool $update): self
    {
        $this->updatePartList = $update;
        return $this;
    }

    public function getPartList(): array
    {
        if (count($this->competitionParts) == 0 && count($this->partList) == 0 ) {
            $this->partList = [1]; // afternoon
        }
        return $this->partList;
    }

    public function setPartList(array $partList): self
    {
        $this->partList = $partList;
        return $this;
    }

    public function competitionPartExists(\DateTimeImmutable $day, int $part): bool
    {
        foreach ($this->competitionParts as $competitionPart) {
            if ($competitionPart->getDay() === $day && $competitionPart->getPart() === $part) return true;
        }
        return false;
    }

    public function getEnrolBeforeDays(): int
    {
        return $this->enrolBeforeDays;
    }

    public function setEnrolBeforeDays(int $enrolBeforeDays): self
    {
        if ($enrolBeforeDays>7) $this->enrolBeforeDays = $enrolBeforeDays;

        return $this;
    }

    public function getEnrolBefore(): \DateTime
    {
        return (clone $this->calendar->getStartTime)->modify('midnight')->modify(sprintf("-%ddays", $this->enrolbeforedays));
    }

    public function getEnrolFrom(): \DateTime
    {
        return $this->enrolFrom;
    }

    public function getEnrol(): bool
    {
        return !is_null($this->enrolFrom);
    }

    public function setEnrol(bool $enrol): self
    {
        if (is_null($this->enrolFrom) && $enrol) {
            $this->enrolFrom = new \DateTimeImmutable('now');
        }

        return $this;
    }

}
