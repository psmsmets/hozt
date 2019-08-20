<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserDetailsRepository")
 */
class UserDetails
{
    /**
     * Parameters
     */
    const MIN_REMINDEROFFSET = 1;
    const MAX_REMINDEROFFSET = 7;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="details", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\Column(type="simple_array")
     */
    private $notificationDays = [];

    /**
     * @ORM\Column(type="smallint")
     */
    private $reminderOffset;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secondaryEmail;

    public function __construct(bool $verified = false)
    {
      $this->notificationDays = range(1,7);
      $this->reminderOffset = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNotificationDaynames(): ?array
    {
        return array_map( function($v){ return jddayofweek($v-1,$mode=1); }, $this->notificationDays );
    }

    public function getNotificationDays(): ?array
    {
        return $this->notificationDays;
    }

    public function setNotificationDays(array $notificationDays): self
    {
        $this->notificationDays = array_unique( $notificationDays, SORT_NUMERIC );

        return $this;
    }

    public function getReminderOffset(): ?int
    {
        return $this->reminderOffset;
    }

    public function setReminderOffset(int $reminderOffset): self
    {
        if ( $reminderOffset < self::MIN_REMINDEROFFSET ) $reminderOffset = self::MIN_REMINDEROFFSET;
        if ( $reminderOffset > self::MAX_REMINDEROFFSET ) $reminderOffset = self::MAX_REMINDEROFFSET;

        $this->reminderOffset = $reminderOffset;

        return $this;
    }

    public function getSecondaryEmail(): ?string
    {
        return $this->secondaryEmail;
    }

    public function setSecondaryEmail(?string $secondaryEmail): self
    {
        $this->secondaryEmail = $secondaryEmail;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('reminderOffset', new Assert\Range([
            'min' => self::MIN_REMINDEROFFSET,
            'max' => self::MAX_REMINDEROFFSET,
            'minMessage' => 'Minimum valid value equals {{ limit }}',
            'maxMessage' => 'Maximum valid value equals {{ limit }}',
        ]));
        $metadata->addPropertyConstraint('secondaryEmail', new Assert\Email([
            'message' => 'The email "{{ value }}" is not a valid email.',
            'checkMX' => true,
        ]));
    }
}
