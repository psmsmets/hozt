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
     * Parameters
     */
    const groupingCategories = array('GROUPING_BOARD','GROUPING_DAILY_OPERATIONS','GROUPING_COACHES','GROUPING_OFFICIALS');

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="smallint")
     */
    private $categoryId;

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

    public function __construct( )
    {
        $this->members = new ArrayCollection();
        $this->categoryId = 0;
        $this->public = false;
    }

    public function __toString()
    {
        return "$this->name";
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getCategory(): ?string
    {
        return self::groupingCategories[$this->categoryId];
    }

    public function setCategory(?string $category): self
    {
        $categoryId = array_search(strtoupper($category),self::groupingCategories);
        if ($categoryId !== false) $this->categoryId = $categoryId;

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

}
