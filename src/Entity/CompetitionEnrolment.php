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
     * @ORM\Column(type="boolean")
     */
    private $restrictions;

    /**
     * @ORM\Column(type="boolean")
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
    private $competitor;

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
        $this->restrictions = $restrictions;
        $this->qualified = false;
        $this->enrolledAt = null;
        $this->notifiedAt = null;
        $this->competitor = $member;
        $this->setCompetitionPart($competitionPart);
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
        $this->enrolled = $enrolled;
        $this->enrolledAt = new \DateTimeImmutable('now');

        return $this;
    }

    public function isEnrolled(): ?bool
    {
        return $this->isEnabled() and $this->enrolled;
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

    public function getRestrictions(): bool
    {
        return is_null($this->qualified);
    }

    public function setRestrictions(bool $restrictions): self
    {
        $this->restrictions = $restrictions;

        return $this;
    }

    public function getQualified(): ?bool
    {
        return !$this->restrictions ? null : $this->qualified;
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

        return $this;
    }

    public function isEnabled(): bool
    {
        if (!$this->filtered) return false;
        return $this->restrictions ? $this->qualified : true;
    }

    public function isDisabled(): bool
    {
        return !$this->isEnabled();
    }

    public function getBtnDisabled(): string
    {
        return $this->isDisabled() ? 'disabled' : '';
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
        return $this->competitor;
    }

    public function getCompetitor(): ?Member
    {
        return $this->competitor;
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
