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
     * @ORM\Column(type="time")
     */
    private $duration;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxEnrolments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $publishAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TryoutEnrolment", mappedBy="tryout")
     */
    private $enrolments;

    public function __construct()
    {
        $this->uuid = bin2hex(random_bytes(8));
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->publishAt = $this->createdAt;
        $this->startTime = new \DateTime("today noon"); 
        $this->duration = new \DateTime("today 1am");
        $this->enabled = true;
        $this->enrolments = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        $fmt = 'Y-m-d H:i';
        return $this->startTime->format($fmt) . " (#)" ;
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

    public function getDuration(): ?\TimeInterface
    {
        return $this->duration;
    }

    public function setDuration(\TimeInterface $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        $endTime = clone $this->startTime;
        return $endTime->modify('+'.$this->duration->format('h').'hour +'.$this->duration->format('i').'min');
    }

    public function getFormattedPeriod(): ?string
    {
        $fmt = "%A %e %B %Y";

        $startTime = $this->getStartTime()->getTimestamp();
        $endTime = $this->getEndTime()->getTimestamp();

        return strftime($fmt.' van %H:%M', $startTime).strftime(' tot %H:%M', $endTime);

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
