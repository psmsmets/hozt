<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnrolmentInputCategoryRepository")
 */
class EnrolmentInputCategory
{
    /**
     * Parameters
     */
    const categoryTypes = array('D'=>'default','I'=>'included','S'=>'supplement');

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
     * @ORM\Column(type="integer")
     */
    private $sequence;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EnrolmentInput", mappedBy="category")
     */
    private $elements;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showTitle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showDescription;

    public function __construct()
    {
        $this->sequence = 0;
        $this->type = 'D';
        $this->showTitle = true;
        $this->showDescription = true;
        $this->elements = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        if ($this->isLocked()) return $this;
        $this->name = $name;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->name;
    }

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(?int $sequence): self
    {
        if ($this->isLocked()) return $this;
        $this->sequence = $sequence;

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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        if ($this->isLocked()) return $this;

        $t = strtoupper(substr($type,0));
        if ( array_key_exists($t, self::categoryTypes) ) $this->type = $t;

        return $this;
    }

    public function getTypeName(): ?string
    {
        return self::categoryTypes[$this->type];
    }

    public function isDefault(): ?bool
    {
        return $this->type === 'D';
    }

    public function isIncluded(): ?bool
    {
        return $this->type === 'I';
    }

    public function isSupplement(): ?bool
    {
        return $this->type === 'S';
    }

    /**
     * @return Collection|EnrolmentInput[]
     */
    public function getElements(): Collection
    {
        return $this->elements;
    }

    public function getLockedElements(): Collection
    {
        return $this->elements->filter(function(EnrolmentInput $input) {
            return $input->isLocked();
        });
    }

    public function hasLockedElements(): ?bool
    {
        return count($this->getLockedElements())>0;
    }

    public function addElement(EnrolmentInput $input): self
    {
        if ($this->isLocked()) return $this;

        if (!$this->elements->contains($input)) {
            $this->elements[] = $input;
            $input->setCategory($this);
        }

        return $this;
    }

    public function removeElement(EnrolmentInput $input): self
    {
        if ($this->elements->contains($input)) {
            $this->elements->removeElement($input);
            // set the owning side to null (unless already changed)
            if ($input->getCategory() === $this) {
                $input->setCategory(null);
            }
        }

        return $this;
    }

    public function getShowTitle(): ?bool
    {
        return $this->showTitle;
    }

    public function setShowTitle(bool $showTitle): self
    {
        $this->showTitle = $showTitle;

        return $this;
    }

    public function getShowDescription(): ?bool
    {
        return $this->showDescription;
    }

    public function setShowDescription(bool $showDescription): self
    {
        $this->showDescription = $showDescription;

        return $this;
    }

    public function isLocked(): ?bool
    {
        return $this->hasLockedElements();
    }

}
