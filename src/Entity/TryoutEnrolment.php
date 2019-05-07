<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ambta\DoctrineEncryptBundle\Configuration\Encrypted;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TryoutEnrolmentRepository")
 */
class TryoutEnrolment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $uuid;

    /**
     * @ORM\Column(type="datetime")
     */
    private $enrolledAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Encrypted
     * @var int
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Encrypted
     * @var int
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=180)
     * @Encrypted
     * @var int
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=15)
     * @Encrypted
     * @var int
     */
    private $telephone;

    /**
     * @ORM\Column(type="date")
     * @Encrypted
     * @var int
     */
    private $birthdate;

    /**
     * @ORM\Column(type="string", length=255)
     * @Encrypted
     * @var int
     */
    private $address;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Encrypted
     * @var int
     */
    private $message;

    /**
     * @ORM\Column(type="boolean")
     */
    private $emailSent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $withdrawn;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $withdrawnAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tryout", inversedBy="category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tryout;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TrainingTeamCategory", inversedBy="tryoutEnrolments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function __construct()
    {
        $this->uuid = bin2hex(random_bytes(8));
        $this->enrolledAt = new \DateTime("now");
        $this->withdrawn = false;
        $this->withdrawnAt = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getEnrolledAt(): ?\DateTimeInterface
    {
        return $this->enrolledAt;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getEmailSent(): ?bool
    {
        return $this->emailSent;
    }

    public function setEmailSent(bool $emailSent): self
    {
        $this->emailSent = $emailSent;

        return $this;
    }

    public function getWithdrawn(): ?bool
    {
        return $this->withdrawn;
    }

    public function setWithdrawn(bool $withdrawn): self
    {
        $this->withdrawn = $withdrawn;
        $this->withdrawnAt = new \DateTime('now');

        return $this;
    }

    public function getWithdrawnAt(): ?\DateTimeInterface
    {
        return $this->withdrawnAt;
    }

    public function getTryout(): ?Tryout
    {
        return $this->tryout;
    }

    public function setTryout(?Tryout $tryout): self
    {
        $this->tryout = $tryout;

        return $this;
    }

    public function getCategory(): ?TrainingTeamCategory
    {
        return $this->category;
    }

    public function setCategory(?TrainingTeamCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}
