<?php

namespace App\Entity;

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
     * @ORM\Column(type="string", length=255)
     */
    private $uuid;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enrolled;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $enrolledAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $notified;

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
     * @ORM\ManyToOne(targetEntity="App\Entity\TrainingTeam", inversedBy="competitionEnrolments")
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Competition", inversedBy="enrolments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $competition;

    public function __construct(Member $member = null)
    {
        $this->uuid = bin2hex(random_bytes(8));
        $this->createdAt = new \DateTimeImmutable('now');
        $this->updatedAt = null;
        $this->enrolled = true;
        $this->enrolledAt = null;
        $this->notified = false;
        $this->notifiedAt = null;
        if (!is_null($member)) $this->setMember($member);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTimeImmutable('now');

        return $this;
    }

    public function getEnrolled(): ?bool
    {
        return $this->enrolled;
    }

    public function setEnrolled(bool $enrolled): self
    {
        $this->enrolled = $enrolled;
        $this->setEnrolledAt();

        return $this;
    }

    public function getEnrolledAt(): ?\DateTimeImmutable
    {
        return $this->enrolledAt;
    }

    public function setEnrolledAt(): self
    {
        $this->enrolledAt = new \DateTimeImmutable('now');

        return $this;
    }

    public function getNotified(): ?bool
    {
        return $this->notified;
    }

    public function setNotified(bool $notified): self
    {
        $this->notified = $notified;
        $this->setNotifiedAt();

        return $this;
    }

    public function getNotifiedAt(): ?\DateTimeImmutable
    {
        return $this->notifiedAt;
    }

    public function setNotifiedAt(): self
    {
        $this->notifiedAt = new \DateTimeImmutable('now');

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

    public function getTeam(): ?TrainingTeam
    {
        return $this->team;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): self
    {
        $this->competition = $competition;

        return $this;
    }

}