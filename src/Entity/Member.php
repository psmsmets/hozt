<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member
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
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $gender;

    /**
     * @ORM\Column(type="date")
     */
    private $birthdate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MemberAddress", inversedBy="members")
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="user_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $registrationId;

    /**
     * @ORM\Column(type="date")
     */
    private $memberSince;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TrainingTeam", inversedBy="members")
     */
    private $team;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="members")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionEnrolment", mappedBy="member", orphanRemoval=true)
     */
    private $competitionEnrolments;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\MemberGrouping", inversedBy="members")
     */
    private $grouping;

    public function __construct()
    {
        $this->uuid = bin2hex(random_bytes(8));
        $this->enabled = true;
        $this->createdAt = new \DateTime('now');
        $this->updatedAt = $this->createdAt;
        $this->memberSince = new \DateTime('first day of September');
        $this->competitionEnrolments = new ArrayCollection();
        $this->grouping = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->getName();
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

    public function isEnabled(): ?bool
    {
        return $this->enabled ? true : false;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getName(bool $reverse=False): ?string
    {
        return $reverse ? "$this->lastname $this->first" : "$this->firstname $this->lastname";
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getAddress(): ?MemberAddress
    {
        return $this->address;
    }

    public function setAddress(?MemberAddress $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getMemberSince(): ?\DateTimeInterface
    {
        return $this->memberSince;
    }

    public function setMemberSince(\DateTimeInterface $memberSince): self
    {
        $this->memberSince = $memberSince;

        return $this;
    }

    public function getRegistrationId(): ?string
    {
        return $this->registrationId;
    }

    public function setRegistrationId(?string $registrationId): self
    {
        $this->registrationId = $registrationId;

        return $this;
    }

    public function getTeam(): ?TrainingTeam
    {
        return $this->team;
    }

    public function setTeam(?TrainingTeam $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|CompetitionEnrolment[]
     */
    public function getCompetitionEnrolments(): Collection
    {
        return $this->competitionEnrolments;
    }

    public function addCompetitionEnrolment(CompetitionEnrolment $competitionEnrolment): self
    {
        if (!$this->competitionEnrolments->contains($competitionEnrolment)) {
            $this->competitionEnrolments[] = $competitionEnrolment;
            $competitionEnrolment->setMember($this);
        }

        return $this;
    }

    public function removeCompetitionEnrolment(CompetitionEnrolment $competitionEnrolment): self
    {
        if ($this->competitionEnrolments->contains($competitionEnrolment)) {
            $this->competitionEnrolments->removeElement($competitionEnrolment);
            // set the owning side to null (unless already changed)
            if ($competitionEnrolment->getMember() === $this) {
                $competitionEnrolment->setMember(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MemberGrouping[]
     */
    public function getGrouping(): Collection
    {
        return $this->grouping;
    }

    public function addGrouping(MemberGrouping $grouping): self
    {
        if (!$this->grouping->contains($grouping)) {
            $this->grouping[] = $grouping;
        }

        return $this;
    }

    public function removeGrouping(MemberGrouping $grouping): self
    {
        if ($this->grouping->contains($grouping)) {
            $this->grouping->removeElement($grouping);
        }

        return $this;
    }

}
