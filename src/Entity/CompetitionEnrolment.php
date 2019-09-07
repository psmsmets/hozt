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
    private $disabled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enrolled;

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

    public function __construct(CompetitionPart $competitionPart, Member $member, bool $enrolled = true, bool $disabled = false)
    {
        $this->createdAt = new \DateTimeImmutable('now');
        $this->enrolled = $enrolled;
        $this->disabled = $disabled;
        $this->enrolledAt = null;
        $this->notifiedAt = null;
        $this->setCompetitionPart($competitionPart);
        $this->setMember($member);
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

    public function getDisabled(): ?bool
    {
        return $this->disabled;
    }

    public function getBtnDisabled(): ?bool
    {
        return $this->disabled or $this->competitionPart->isInactive();
    }

    public function getBtnDisabledString(): string
    {
        return $this->getBtnDisabled() ? 'disabled' : '';
    }

    public function setDisabled(bool $disabled): self
    {
        $this->enrolled = $disabled;

        return $this;
    }

    public function getNotifiedAt(): ?\DateTimeImmutable
    {
        return $this->notifiedAt;
    }

    public function getNotified(): ?bool
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

    public function setMember(?Member $member): self
    {
        $this->member = $member;
        $this->team = $member->getTeam();

        return $this;
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
