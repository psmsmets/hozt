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
     * Parameters
     */
    const minAge = 5;
    const maxAge = 130;

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
     * @ORM\Column(type="smallint")
     */
    private $maleBirthyearMin;

    /**
     * @ORM\Column(type="smallint")
     */
    private $maleBirthyearMax;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $femaleAgeMin;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     */
    private $femaleAgeMax;

    /**
     * @ORM\Column(type="smallint")
     */
    private $femaleBirthyearMin;

    /**
     * @ORM\Column(type="smallint")
     */
    private $femaleBirthyearMax;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionPart", mappedBy="competition", orphanRemoval=true)
     */
    private $competitionParts;

    /**
     * @ORM\Column(type="smallint")
     */
    private $enrolBeforeDays;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $enrolBefore;

    /**
     * Virtual variables
     */
    private $updateFilter = false;
    private $partList = [];
    private $updatePartList = false;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->enrolBeforeDays = 21;
        $this->overnight = false;
        $this->registrationId = true;
        $this->similarGenderAgeLimits = true;
        $this->teams = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->competitionParts = new ArrayCollection();
    }

    public function __toString(): string
    {
        return sprintf('%s %s (%s)', 
                $this->calendar->getStartTime()->format('Y-m-d'), 
                $this->calendar->getTitle(),
                $this->calendar->getLocation()
            );
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

        $this->setEnrolBefore();

        $this->setMaleBirthyearMin();
        $this->setMaleBirthyearMax();

        $this->setFemaleBirthyearMin();
        $this->setFemaleBirthyearMax();

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
        $this->organization = strtoupper($organization);

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
     * @return Collection|TrainingTeam[]
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(TrainingTeam $team): self
    {
        if (!$this->teams->contains($team)) {
            $this->updateFilter = true;
            $this->teams[] = $team;
        }

        return $this;
    }

    public function removeTeam(TrainingTeam $team): self
    {
        if ($this->teams->contains($team)) {
            $this->updateFilter = true;
            $this->teams->removeElement($team);
        }

        return $this;
    }

    public function getRestrictions(): ?bool
    {
        return $this->restrictions;
    }

    public function setRestrictions(bool $restrictions): self
    {
        if ($restrictions != $this->restrictions) $this->updateFilter = true;
        $this->restrictions = $restrictions;

        return $this;
    }

    public function getRegistrationId(): ?bool
    {
        return $this->registrationId;
    }

    public function setRegistrationId(bool $registrationId): self
    {
        if ($registrationId != $this->registrationId) $this->updateFilter = true;
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
        if ($similarGenderAgeLimits != $this->similarGenderAgeLimits) $this->updateFilter = true;
        $this->similarGenderAgeLimits = $similarGenderAgeLimits;

        return $this;
    }

    public function duplicateGenderAgeLimits(): self
    {
        $this->femaleAgeMin = $this->maleAgeMin;
        $this->femaleAgeMax = $this->maleAgeMax;

        $this->femaleBirthyearMin = $this->maleBirthyearMin;
        $this->femaleBirthyearMax = $this->maleBirthyearMax;

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

    public function hasMaleAgeMin(): bool
    {
        return !is_null($this->maleAgeMin);
    }

    public function setMaleAgeMin(?int $maleAgeMin): self
    {
        if ($maleAgeMin != $this->maleAgeMin) $this->updateFilter = true;
        $this->maleAgeMin = $maleAgeMin;
        $this->setMaleBirthyearMax();

        return $this;
    }

    public function getMaleAgeMax(): ?int
    {
        return $this->maleAgeMax;
    }

    public function hasMaleAgeMax(): bool
    {
        return !is_null($this->maleAgeMax);
    }

    public function setMaleAgeMax(?int $maleAgeMax): self
    {
        if ($maleAgeMax != $this->maleAgeMax) $this->updateFilter = true;
        $this->maleAgeMax = $maleAgeMax;
        $this->setMaleBirthyearMin();

        return $this;
    }

    private function setMaleBirthyearMin(): self
    {
        if (is_null($this->calendar)) return $this;

        $this->maleBirthyearMin = (int) $this->calendar->getStartTime()->format('Y');

        if (is_null($this->maleAgeMax)) {
            $this->maleBirthyearMin -= self::maxAge;
        } else {
            $this->maleBirthyearMin -= $this->maleAgeMax;
        }

        return $this;
    }

    public function getMaleBirthyearMin(): ?int
    {
        return $this->maleBirthyearMin;
    }

    public function hasMaleBirthyearMin(): bool
    {
        return !is_null($this->maleAgeMax);
    }

    private function setMaleBirthyearMax(): self
    {
        if (is_null($this->calendar)) return $this;

        $this->maleBirthyearMax = (int) $this->calendar->getStartTime()->format('Y');

        if (is_null($this->maleAgeMin)) {
            $this->maleBirthyearMax -= self::minAge;
        } else {
            $this->maleBirthyearMax -= $this->maleAgeMin;
        }

        return $this;
    }

    public function getMaleBirthyearMax(): ?int
    {
        return $this->maleBirthyearMax;
    }

    public function hasMaleBirthyearMax(): bool
    {
        return !is_null($this->maleAgeMin);
    }

    public function getFemaleAgeMin(): ?int
    {
        return $this->femaleAgeMin;
    }

    public function hasFemaleAgeMin(): bool
    {
        return !is_null($this->femaleAgeMin);
    }

    public function setFemaleAgeMin(?int $femaleAgeMin): self
    {
        if ($femaleAgeMin != $this->femaleAgeMin) $this->updateFilter = true;
        $this->femaleAgeMin = $femaleAgeMin;
        $this->setFemaleBirthyearMax();

        return $this;
    }

    public function getFemaleAgeMax(): ?int
    {
        return $this->femaleAgeMax;
    }

    public function hasFemaleAgeMax(): bool
    {
        return !is_null($this->femaleAgeMax);
    }

    public function setFemaleAgeMax(?int $femaleAgeMax): self
    {
        if ($femaleAgeMax != $this->femaleAgeMax) $this->updateFilter = true;
        $this->femaleAgeMax = $femaleAgeMax;
        $this->setFemaleBirthyearMin();

        return $this;
    }

    private function setFemaleBirthyearMin(): self
    {
        if (is_null($this->calendar)) return $this;

        $this->femaleBirthyearMin = (int) $this->calendar->getStartTime()->format('Y');

        if (is_null($this->femaleAgeMax)) {
            $this->femaleBirthyearMin -= self::maxAge;
        } else {
            $this->femaleBirthyearMin -= $this->femaleAgeMax;
        }

        return $this;
    }

    public function getFemaleBirthyearMin(): ?int
    {
        return $this->femaleBirthyearMin;
    }

    public function hasfemaleBirthyearMin(): bool
    {
        return !is_null($this->femaleAgeMax);
    }

    private function setFemaleBirthyearMax(): self
    {
        if (is_null($this->calendar)) return $this;

        $this->femaleBirthyearMax = (int) $this->calendar->getStartTime()->format('Y');

        if (is_null($this->femaleAgeMin)) {
            $this->femaleBirthyearMax -= self::minAge;
        } else {
            $this->femaleBirthyearMax -= $this->femaleAgeMin;
        }

        return $this;
    }

    public function getFemaleBirthyearMax(): ?int
    {
        return $this->femaleBirthyearMax;
    }

    public function hasfemaleBirthyearMax(): bool
    {
        return !is_null($this->femaleAgeMin);
    }

    public function hasAgeLimits(): bool
    {
        return !is_null($this->maleBirthyearMin) or !is_null($this->femaleBirthyearMin) 
            or !is_null($this->maleBirthyearMax) or !is_null($this->femaleBirthyearMax);
    }

    /**
     * @return Collection|CompetitionPart[]
     */
    public function getCompetitionParts(): Collection
    {
        return $this->competitionParts;
    }

    public function hasCompetitionParts(): bool
    {
        return count($this->getCompetitionParts())>0;
    }

    public function getEnabledCompetitionParts(): Collection
    {
        return $this->competitionParts->filter(function(CompetitionPart $competitionPart) {
            return $competitionPart->isActive() and $competitionPart->hasEnrolments();
        });
    }

    public function hasEnabledCompetitionParts(): bool
    {
        return count($this->getEnabledCompetitionParts())>0;
    }

    public function getNewCompetitionEnrolments(User $user=null): Collection
    {
        return $this->competitionParts->filter(function(CompetitionPart $competitionPart) use($user) {
            return $competitionPart->isActive() and $competitionPart->hasNewEnrolments($user);
        });
    }

    public function hasNewCompetitionEnrolments(User $user=null): bool
    {
        return count($this->getNewCompetitionEnrolments($user))>0;
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

    public function getUpdateFilter(): bool
    {
        return $this->updateFilter;
    }

    public function setUpdateFilter(bool $update): self
    {
        $this->updateFilter = $update;
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

    public function competitionPartExists(\DateTimeInterface $day, int $part): bool
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
        if ($enrolBeforeDays >= 7) $this->enrolBeforeDays = $enrolBeforeDays;
        $this->setEnrolBefore();

        return $this;
    }

    private function setEnrolBefore(): self
    {
        $di = new \DateInterval(sprintf("P%dD", $this->enrolBeforeDays));

        $this->enrolBefore = \DateTimeImmutable::createFromMutable($this->calendar->getStartTime());
        $this->enrolBefore = $this->enrolBefore->setTime(0,0)->sub($di);

        return $this;
    }

    public function getEnrolBefore(): \DateTimeInterface
    {
        return $this->enrolBefore;
    }

    public function getEnrol(): bool
    {
        return $this->hasEnabledCompetitionParts();
    }

}
