<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Constraints as Assert;

//use Ambta\DoctrineEncryptBundle\Configuration\Encrypted;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * Parameters
     */
    const PASSWORD_RESET = 'password_reset_token';
    const EMAIL_VERIFICATION = 'email_verification_token';
    const PASSWORD_REGEX = '^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[_!@#$%^&*(),.?":{}|<> ])\S{6,}$';
    const PASSWORD_REQUIREMENTS = array(
            'length' => 'Een wachtwoord bevat minstens 6 tekens waarvan',
            'details' => array(
                '1 kleine letter (a-z)',
                '1 hoofdletter (A-Z)',
                '1 getal (0-9)',
                '1 symbool (?=.*[_!@#$%^&*(),.?":{}|<> ])',
            ),
        );

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=15, unique=true)
     */
    private $mobilePhone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $verified;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLoginAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $passwordUpdatedAt;

    /**
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $secret;

    /**
     * @ORM\Column(type="datetime")
     */
    private $secretExpiration;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BlogPost", mappedBy="author")
     */
    private $blogPosts;

    public function __construct()
    {
      $this->createdAt = new \DateTime("now");
      $this->passwordUpdatedAt = $this->createdAt;
      $this->password = bin2hex(random_bytes(64));
      $this->enabled = true;
      $this->verified = false;
      $this->isActive = false;
      $this->roles = array();
      $this->secret = null;
      $this->secretExpiration = $this->createdAt;
      $this->blogPosts = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return "$this->firstname $this->lastname";
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = array_unique($roles);
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->passwordUpdatedAt = new \DateTime("now");
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
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

    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    public function setMobilePhone(string $mobilePhone): self
    {
        $this->mobilePhone = $mobilePhone;
        return $this;
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

    public function getVerified(): ?bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): self
    {
        $this->verified = $verified;
        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->verified ? true : false;
    }

    public function getLastLoginAt(): ?\DateTimeInterface
    {
        return $this->lastLoginAt;
    }

    public function updateLastLoginAt(): self
    {
        $this->lastLoginAt = new \DateTime("now");
        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive ? true : false;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getPasswordUpdatedAt(): ?\DateTimeInterface
    {
        return $this->passwordUpdatedAt;
    }

    public function isPasswordExpired(): ?bool
    {
        return false;
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getBlogPosts(): Collection
    {
        return $this->blogPosts;
    }

    public function addBlogPost(BlogPost $blogPost): self
    {
        if (!$this->blogPosts->contains($blogPost)) {
            $this->blogPosts[] = $blogPost;
            $blogPost->setAuthor($this);
        }
        return $this;
    }

    public function removeBlogPost(BlogPost $blogPost): self
    {
        if ($this->blogPosts->contains($blogPost)) {
            $this->blogPosts->removeElement($blogPost);
            // set the owning side to null (unless already changed)
            if ($blogPost->getAuthor() === $this) {
                $blogPost->setAuthor(null);
            }
        }
        return $this;
    }

    /**
     * @see Security
     */
    private function newSecret(string $type = null): self
    {
        if (is_null($type)) return null;

        $this->secretExpiration = new \DateTime("now +1 hour");
        $token =  hash(
            'sha256', 
            $this->email . " " . $this->secretExpiration->getTimestamp() . " " . bin2hex(random_bytes(32)) 
        );
        $this->secret = "$type=$token";

        return $this;
    }

    private function getToken(string $type = null): ?string 
    {
        list($token_type, $token) = explode("=", $this->getSecret());
        return (is_null($type) or $type != $token_type) ? null : $token;
    }

    public function getSecret(): ?string 
    {
        return $this->secret;
    }

    public function getSecretExpiration(): ?\DateTimeInterface
    {
        return $this->secretExpiration;
    }

    public function expireSecret(): self
    {  
        $this->secretExpiration = new \DateTime("now -100 year");
        $this->secret = null;
        return $this;
    }

    public function newResetPasswordToken(): ?string
    {
        $this->newSecret(self::PASSWORD_RESET);
        return $this->getToken(self::PASSWORD_RESET);
    }

    public function getResetPasswordToken(): ?string
    {
        return $this->getToken(self::PASSWORD_RESET);
    }

    public function newEmailVerificationToken(): ?string
    {
        $this->newSecret(self::EMAIL_VERIFICATION);
        return $this->getToken(self::EMAIL_VERIFICATION);
    }

    public function getEmailVerificationToken(): ?string
    {
        return $this->getToken(self::EMAIL_VERIFICATION);
    }

/*
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('firstName', new Assert\Length([
            'min' => 2,
            'max' => 50,
            'minMessage' => 'Your first name must be at least {{ limit }} characters long',
            'maxMessage' => 'Your first name cannot be longer than {{ limit }} characters',
        ]));
    }
*/

}
