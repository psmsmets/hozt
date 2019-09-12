<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberAddressRepository")
 */
class MemberAddress
{

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3)
     */
    private $nation;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $town;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Member", mappedBy="address")
     */
    private $members;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="memberAddresses")
     */
    private $user;

    public function __construct(User $user=null)
    {
        $this->nation = 'BE';
        $this->members = new ArrayCollection();
        $this->user = $user;
    }

    public function __toString(): ?string
    {
        return sprintf("%s, %s %s, %s", $this->getStreet(), $this->getZip(), $this->getTown(), $this->getNation());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNation(): ?string
    {
        return $this->nation;
    }

    public function setNation(string $nation): self
    {
        $this->nation = $nation;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getTown(): ?string
    {
        return $this->town;
    }

    public function setTown(string $town): self
    {
        $this->town = $town;

        return $this;
    }

    /**
     * @return Collection|Member[]
     */
    public function getMembers(): Collection
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!$this->members->contains($member)) {
            $this->members[] = $member;
            $member->setAddress($this);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            // set the owning side to null (unless already changed)
            if ($member->getAddress() === $this) {
                $member->setAddress(null);
            }
        }

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
}
