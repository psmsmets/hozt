<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionPartRepository")
 */
class CompetitionPart
{
    /**
     * Parameters
     */
    const dayParts = array(1 => 'morning', 2 => 'afternoon', 3 => 'evening');
    const dayPartsInv = array('morning' => 1, 'afternoon' => 2, 'evening' => 3);

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
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;


    /**
     * @ORM\Column(type="smallint")
     */
    private $part;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Competition", inversedBy="competitionParts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $competition;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionEnrolment", mappedBy="competitionPart")
     * @ORM\JoinColumn(nullable=false)
     */
    private $enrolments;

    /**
     * @ORM\Column(type="date_immutable")
     */
    private $date;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable("now");
        $this->updatedAt = $this->createdAt;
        $this->enrolments = new ArrayCollection();
    }

    public function __toString(): string
    {
        return strval($this->competition)." ".$this->getDaypart();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPart(): ?int
    {
        return $this->part;
    }

    public function setPart(int $part): self
    {
        $this->part = $part;

        return $this;
    }

    public function getDaypart(): ?string
    {
        return CompetitionPart::dayParts[$this->part];
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

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): self
    {
        $this->date = $date;

        return $this;
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
