<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberGroupingRepository")
 */
class MemberGrouping
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MemberGrouping", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MemberGrouping", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Member", mappedBy="grouping")
     */
    private $members;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sequence;

    /**
     * @ORM\Column(type="boolean")
     */
    private $public;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $slug;

    public function __construct( )
    {
        $this->members = new ArrayCollection();
        $this->public = false;
    }

    public function __toString()
    {
        return "$this->fullname";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name ): self
    {
        $this->name = $name;
        $this->setFullname();

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(): self
    {
        $fullname = $this->name;
        if ($parent = $this->getParent()) $fullname = $parent->getName()." - $fullname";
        $this->fullname = $fullname;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getParent(): ?MemberGrouping
    {
        return $this->parent;
    }

    public function setParent(?MemberGrouping $parent): self
    {
        $this->parent = $parent;
        $this->setFullname();

        return $this;
    }

    /**
     * @return Collection|MemberGrouping[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(MemberGrouping $child)
    {
       $this->children[] = $child;
       $child->setParent($this);
    }

    public function removeChild(MemberGrouping $child)
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            $children->removeGrouping($this);
        }

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
            $member->addGrouping($this);
        }

        return $this;
    }

    public function removeMember(Member $member): self
    {
        if ($this->members->contains($member)) {
            $this->members->removeElement($member);
            $member->removeGrouping($this);
        }

        return $this;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(?int $sequence): self
    {
        $this->sequence = $sequence;

        return $this;
    }

    public function getPublic(): ?bool
    {
        return $this->public;
    }

    public function setPublic(bool $public): self
    {
        $this->public = $public;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

}
