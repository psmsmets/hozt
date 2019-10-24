<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnrolmentInputRepository")
 */
class EnrolmentInput
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EnrolmentInputCategory", inversedBy="elements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $help;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $unitPrice;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $totalNumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EnrolmentEvent", inversedBy="inputs")
     */
    private $event;

    /**
     * Virtual variables
     */
    private $number = 0;

    public function __construct()
    {
        $this->totalNumber = 0;
    }

    public function __toString(): ?string
    {
        return $this->category." :: ".$this->name;
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

    public function getCategory(): ?EnrolmentInputCategory
    {
        return $this->category;
    }

    public function setCategory(?EnrolmentInputCategory $category): self
    {
        if ($this->isLocked()) return $this;
        $this->category = $category;

        return $this;
    }

    public function getHelp(): ?string
    {
        return $this->help;
    }

    public function setHelp(string $help): self
    {
        $this->help = $help;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUnitPrice(): ?float
    {
        if (is_null($this->category)) return $this->unitPrice;
        return $this->category->isIncluded() ? null : $this->unitPrice;
    }

    public function setUnitPrice(?float $unitPrice): self
    {
        if ($this->isLocked()) return $this;
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function hasUnitPrice(): ?bool
    {
        return !is_null($this->getUnitPrice());
    }

    public function getTotalNumber(): ?int
    {
        return $this->totalNumber;
    }

    public function addTotalNumber(?int $number): self
    {
        $this->totalNumber += $number;

        return $this;
    }

    public function getSlug(): ?string
    {
        return "enrolmentInput_".$this->id;
    }

    public function getEvent(): ?EnrolmentEvent
    {
        return $this->event;
    }

    public function setEvent(?EnrolmentEvent $event): self
    {
        $this->event = $event;

        return $this;
    }

    public function isLocked(): ?bool
    {
        if (is_null($this->event)) return false;
        return $this->event->getEnabled();
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number ? $number : 0;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->hasUnitPrice() ? $this->number * $this->unitPrice : 0.;
    }

    public function getTotalPrice(): ?int
    {
        return $this->hasUnitPrice() ? $this->totalNumber * $this->unitPrice : 0.;
    }

}
