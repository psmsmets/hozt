<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionEnrolmentRepository")
 */
class CompetitionEnrolment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;
    /**
     * @ORM\Column(type="boolean")
     */
    private $enrolled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $filtered;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $qualified;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $enrolledAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $notifiedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="competitionEnrolments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CompetitionPart", inversedBy="enrolments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $competitionPart;

    public function __construct(CompetitionPart $competitionPart, Member $member, bool $enrolled, bool $filtered, bool $restrictions)
    {
        $this->createdAt = new \DateTimeImmutable('now');
        $this->enrolled = $enrolled;
        $this->filtered = $filtered;
        $this->enrolledAt = null;
        $this->notifiedAt = null;
        $this->setRestrictions($restrictions);
        $this->setCompetitionPart($competitionPart);
        $this->member = $member;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getEnrolledAt(): ?\DateTimeImmutable
    {
        return $this->enrolledAt;
    }

    public function getEnrolled(): ?bool
    {
        return $this->enrolled;
    }

    public function setEnrolled(bool $enrolled): self
    {
        if ($enrolled) {
            $this->enrolled = $enrolled;
            $this->enrolledAt = new \DateTimeImmutable('now');
        }

        return $this;
    }

    public function getFiltered(): bool
    {
        return $this->filtered;
    }

    public function setFiltered(bool $filtered): self
    {
        $this->filtered = $filtered;

        return $this;
    }

    public function setRestrictions(bool $restrictions): self
    {
        if ($restrictions) {
            if (!is_null($self->qualified)) $self->qualified = false;
        } else {
            $self->qualified = null;
        }

        return $this;
    }

    public function getQualified(): ?bool
    {
        return $this->qualified;
    }

    public function setQualified(bool $qualified): self
    {
        $this->qualified = $qualified;

        return $this;
    }

    public function updateEnrolment(bool $filtered, bool $restrictions): self
    {
        $this->filtered = $filtered;
        $this->setRestrictions($restrictions);
    }

    public function getDisabled(): bool
    {
        return !$this->filtered;
    }

    public function getBtnDisabled(): string
    {
        return $this->getDisabled() ? 'disabled' : '';
    }

    public function getNotifiedAt(): ?\DateTimeImmutable
    {
        return $this->notifiedAt;
    }

    public function getNotified(): bool
    {
        return !is_null($this->notifiedAt);
    }

    public function setNotified(bool $notified): self
    {
        if ($notified) $this->notifiedAt = new \DateTimeImmutable('now');

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function getCompetitionPart(): ?CompetitionPart
    {
        return $this->competitionPart;
    }

    public function setCompetitionPart(?CompetitionPart $competitionPart): self
    {
        $this->competitionPart = $competitionPart;

        return $this;
    }
}
