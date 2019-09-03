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
     * @ORM\Column(type="date")
     */
    private $day;

    /**
     * @ORM\Column(type="smallint")
     */
    private $part;

    /**
     * @ORM\Column(type="string", length=32)
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

    public function __construct(Competition $competition, \DateTime $day, int $part)
    {
        $this->enabledAt = null;
        $this->competition = $competition;
        $this->day = $day;
        if (array_key_exists($part,CompetitionPart::dayParts)) $this->part = $part;
        $this->hash = md5(sprintf('%d;%d;%d', $this->competition->getCalendar()->getId(), $this->day->getTimestamp(), $this->part ));
        $this->enrolments = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    public function getName(): string
    {
        return sprintf('%s %s %s', $this->day->format('Y-m-d'), $this->competition->getCalendar()->getLocation(), $this->getDaypart());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function getEnabledAt(): ?\DateTime
    {
        return $this->enabledAt;
    }

    public function getEnabled(): ?bool
    {
        return !is_null($this->enabledAt);
    }

    public function setEnabled(bool $enabled): self
    {
        if (is_null($this->enabledAt) && $enabled) {
            $this->enabled = true;
            $this->enabledAt = new \DateTime('now');
        }

        return $this;
    }

    public function getDay(): ?\DateTime
    {
        return $this->day;
    }

    public function getPart(): ?int
    {
        return $this->part;
    }

    public function getDaypart(): ?string
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
