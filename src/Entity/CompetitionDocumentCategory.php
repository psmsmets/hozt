<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompetitionDocumentCategoryRepository")
 */
class CompetitionDocumentCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $sequence;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $autoCleanup;

    /**
     * @ORM\Column(type="smallint")
     */
    private $cleanupDelay;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompetitionDocument", mappedBy="category")
     */
    private $documents;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->enabled = true;
        $this->autoCleanup = false;
        $this->cleanupDelay = 999;
        $this->documents = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTime("now");

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = strtolower($slug);

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

    public function getSequence(): ?int
    {
        return $this->sequence;
    }

    public function setSequence(int $sequence): self
    {
        $this->sequence = $sequence;

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

    public function getAutoCleanup(): ?bool
    {
        return $this->autoCleanup;
    }

    public function setAutoCleanup(bool $autoCleanup): self
    {
        $this->autoCleanup = $autoCleanup;

        return $this;
    }

    public function getCleanupDelay(): ?int
    {
        return $this->cleanupDelay;
    }

    public function setCleanupDelay(int $cleanupDelay): self
    {
        $this->cleanupDelay = abs($cleanupDelay);

        return $this;
    }

    /**
     * @return Collection|CompetitionDocument[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(CompetitionDocument $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setCategory($this);
        }

        return $this;
    }

    public function removeDocument(CompetitionDocument $document): self
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getCategory() === $this) {
                $document->setCategory(null);
            }
        }

        return $this;
    }

}
