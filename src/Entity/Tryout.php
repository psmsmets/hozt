<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TryoutRepository")
 */
class Tryout
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $uuid;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startTime;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endTime;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxEnrolments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TryoutEnrolment", mappedBy="tryout")
     */
    private $enrolments;

    public function __construct()
    {
        $this->uuid = bin2hex(random_bytes(8));
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->startTime = new \DateTime("today noon"); 
        $this->endTime = new \DateTime("today noon +1 hour");
        #$this->endTime->modify('+1 hour');
        $this->enabled = true;
        $this->enrolments = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        $fmt = 'Y-m-d H:M';
        return $this->startTime->format($fmt) . " " . $this->endTime->format($fmt);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
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
        $this->updatedAt = new \DateTime('now');

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getMaxEnrolments(): ?int
    {
        return $this->maxEnrolments;
    }

    public function setMaxEnrolments(int $maxEnrolments): self
    {
        $this->maxEnrolments = $maxEnrolments < 1 ? 1 : $maxEnrolments;

        return $this;
    }

    public function getPublishAt(): ?\DateTimeInterface
    {
        return $this->publishAt;
    }

    public function setPublishAt(\DateTimeInterface $publishAt): self
    {
        if ($this->startTime->diff($publishAt)->days < 14) {
           $publishAt = clone $this->startTime;
           $publishAt->modify('-14 days');
        }
        $this->publishAt = $publishAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|TryoutEnrolment[]
     */
    public function getEnrolments(): Collection
    {
        return $this->enrolments;
    }

    public function addEnrolment(TryoutEnrolment $enrolments): self
    {
        if (!$this->enrolments->contains($enrolments)) {
            $this->enrolments[] = $enrolments;
            $enrolments->setTryout($this);
        }

        return $this;
    }

    public function removeEnrolment(TryoutEnrolment $enrolments): self
    {
        if ($this->enrolments->contains($enrolments)) {
            $this->enrolments->removeElement($enrolments);
            // set the owning side to null (unless already changed)
            if ($enrolments->getTryout() === $this) {
                $enrolments->setTryout(null);
            }
        }

        return $this;
    }

}
