<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionPartRepository")
 */
class CompetitionPart
{
    /**
     * Parameters
     */
    const dayParts = array('morning', 'afternoon', 'evening');

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Virtual variable
     */
    private $enabled;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $enabledAt;

    /**
     * Virtual variable
     */
    private $cancelled;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $cancelledAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $daypart;

    /**
     * @ORM\Column(type="smallint")
     */
    private $part;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     */
    private $hash;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Competition", inversedBy="competitionParts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $competition;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionEnrolment", mappedBy="competitionPart")
     */
    private $enrolments;

    public function __construct(Competition $competition, \DateTimeImmutable $day, int $part)
    {
        $this->enabledAt = null;
        $this->cancelledAt = null;
        $this->archived = false;
        $this->competition = $competition;
        if (array_key_exists($part,CompetitionPart::dayParts)) {
            $this->part = $part;
            $this->daypart = $day->setTime(0,$this->part);
            $this->hash = md5(sprintf('%d;%d;%d', $this->competition->getCalendar()->getId(), $this->daypart->getTimestamp(), $this->part ));
        }
        $this->enrolments = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return sprintf('%s | %s | %s', $this->daypart->format('Y-m-d'), $this->competition->getCalendar()->getLocation(), $this->getPartName());
    }

    public function getFullName(): string
    {
        $calendar = $this->competition->getCalendar();
        return sprintf('%s %s %s %s', $this->daypart->format('Y-m-d'), $calendar->getTitle(), $calendar->getLocation(), $this->getPartName());
    }

    public function getLongName(): string
    {
        $calendar = $this->competition->getCalendar();
        return sprintf('%s | %s | %s', $this->daypart->format('Y-m-d'), $calendar->getTitle(), $calendar->getLocation());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function getEnabledAt(): ?\DateTimeInterface
    {
        return $this->enabledAt;
    }

    public function getEnabled(): ?bool
    {
        return !is_null($this->enabledAt);
    }

    public function isDraft(): ?bool
    {
        return !$this->getEnabled();
    }

    public function isActive(): ?bool
    {
        return $this->getEnabled() and !$this->getCancelled();
    }

    public function isInactive(): ?bool
    {
        return $this->isDraft() or $this->getCancelled();
    }

    public function setEnabled(bool $enabled): self
    {
        if (is_null($this->enabledAt) and $enabled) {
            $this->enabled = true;
            $this->enabledAt = new \DateTimeImmutable('now');
        }

        return $this;
    }

    public function getCancelledAt(): ?\DateTimeInterface
    {
        return $this->cancelledAt;
    }

    public function getCancelled(): ?bool
    {
        return !is_null($this->cancelledAt);
    }

    public function setCancelled(bool $cancelled): self
    {
        if (is_null($this->cancelledAt) && $cancelled) {
            $this->cancelled = true;
            $this->cancelledAt = new \DateTimeImmutable('now');
        }

        return $this;
    }

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getDay(): ?\DateTimeImmutable
    {
        return $this->daypart->modify('midnight');
    }

    public function getDayPart(): ?\DateTimeInterface
    {
        return $this->daypart;
    }

    public function getPartId(): ?int
    {
        return $this->part;
    }

    public function getPartName(): ?string
    {
        return CompetitionPart::dayParts[$this->part];
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    /**
     * @return Collection|CompetitionEnrolment[]
     */
    public function getEnrolments(): Collection
    {
        return $this->enrolments;
    }

    public function hasEnrolments(): bool
    {
        return count($this->enrolments)>0;
    }

    public function getNewEnrolments(): Collection
    {
        return $this->enrolments->filter(function(CompetitionEnrolment $enrolment) {
            return is_null($enrolment->getEnrolledAt());
        });
    }

    public function hasNewEnrolments(): bool
    {
        return count($this->getNewEnrolments())>0;
    }

    public function getMemberEnrolment(Member $member): ?CompetitionEnrolment
    {
        $enrolment = $this->enrolments->filter(function(CompetitionEnrolment $enrolment) use($member) {
            return $enrolment->getMember() === $member;
        });
        return count($enrolment)==1 ? $enrolment[0] : null;
    }

    public function hasMemberEnrolment(Member $member): bool
    {
        return !is_null($this->getMemberEnrolment($member));
    }

    public function addEnrolment(CompetitionEnrolment $enrolment): self
    {
        if (!$this->enrolments->contains($enrolment)) {
            $this->enrolments[] = $enrolment;
            $enrolment->setCompetitionPart($this);
        }

        return $this;
    }

    public function removeEnrolment(CompetitionEnrolment $enrolment): self
    {
        if ($this->enrolments->contains($enrolment)) {
            $this->enrolments->removeElement($enrolment);
            // set the owning side to null (unless already changed)
            if ($enrolment->getCompetitionPart() === $this) {
                $enrolment->setCompetitionPart(null);
            }
        }

        return $this;
    }
}
