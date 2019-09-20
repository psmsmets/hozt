<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DocumentCategoryRepository")
 */
class DocumentCategory 
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
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DocumentCategory", inversedBy="children")
     * @ORM\JoinColumn(name="parent", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DocumentCategory", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Document", mappedBy="category")
     */
    private $documents;

    public function __construct( )
    {
        $this->documents = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getFullname();
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
        $this->name = $name;

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

    public function getNamelist(DocumentCategory $parent=null, array $namelist=[]): array
    {
        if (is_null($namelist)) {
            $namelist = array($this->name);
            $parent = $this->getParent();
        }
        if ($parent) $namelist[] = $parent->getName();
        if ($parent->hasParent()) $this->getNamelist($parent,$namelist);

        return array_reverse($namelist);
    }

    public function getFullname(string $separator=" "): string
    {
        return join($separator, $this->getNamelist());
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

    public function getParent(): ?DocumentCategory
    {
        return $this->parent;
    }

    public function setParent(?DocumentCategory $parent): self
    {
        $this->parent = $parent;
        $this->setFullname();

        return $this;
    }

    public function hasParent(): bool
    {
        return !is_null($this->parent);
    }

    /**
     * @return Collection|MemberGrouping[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(DocumentCategory $child)
    {
       $this->children[] = $child;
       $child->setParent($this);
    }

    public function removeChild(DocumentCategory $child)
    {
        if ($this->children->contains($child)) {
            $this->children->removeElement($child);
            $children->removeCategory($this);
        }

        return $this;
    }

    public function hasChildren(): bool
    {
        return count($this->children) > 0;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->addCategory($this);
        }

        return $this;
    }

    public function removeDocument(Member $document): self
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            $member->removeCategory($this);
        }

        return $this;
    }

}
