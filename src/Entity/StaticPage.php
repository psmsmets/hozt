<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StaticPageRepository")
 * @Vich\Uploadable
 */
class StaticPage
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
    private $title;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $titleShort;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $access = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $showUpdatedAt;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $keywords;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="staticPage_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document;

    /**
     * @Vich\UploadableField(mapping="blogPost_documents", fileNameProperty="document")
     * @var File
     */
    private $documentFile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CalendarEvent", mappedBy="staticPage")
     */
    private $calendar;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->enabled = true;
        $this->showUpdatedAt = false;
        $this->calendar = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->slug;
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitleShort(): ?string
    {
        return $this->titleShort;
    }

    public function setTitleShort(?string $titleShort): self
    {
        $this->titleShort = $titleShort;

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

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getAccess(): ?array
    {
        return $this->access;
    }

    public function setAccess(?array $access): self
    {
        $this->access = $access;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getShowCreatedAt(): ?bool
    {
        return $this->show_createdAt;
    }

    public function setShowCreatedAt(bool $show_createdAt): self
    {
        $this->show_createdAt = $show_createdAt;

        return $this;
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

    public function getShowUpdatedAt(): ?bool
    {
        return $this->showUpdatedAt;
    }

    public function setShowUpdatedAt(bool $showUpdatedAt): self
    {
        $this->showUpdatedAt = $showUpdatedAt;

        return $this;
    }

    public function getKeywords()
    {
        return $this->keywords;
    }

    public function setKeywords($keywords): self
    {
        $this->keywords = $keywords;

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getDocument(): ?string
    {
        return $this->document;
    }

    public function setDocument(?string $document): self
    {
        $this->document = $document;

        return $this;
    }

    public function setDocumentFile(File $document = null)
    {
        $this->documentFile = $document;

        // VERY IMPORTANT:
        // It is required that at least one field changes if you are using Doctrine,
        // otherwise the event listeners won't be called and the file is lost
        if ($document) {
            $this->updatedAt = new \DateTime('now');
        }
    }

    public function getDocumentFile()
    {
        return $this->documentFile;
    }

    /**
     * @return Collection|CalendarEvent[]
     */
    public function getCalendar(): Collection
    {
        return $this->calendar;
    }

    public function addCalendar(CalendarEvent $calendar): self
    {
        if (!$this->calendar->contains($calendar)) {
            $this->calendar[] = $calendar;
            $calendar->setStaticPage($this);
        }

        return $this;
    }

    public function removeCalendar(CalendarEvent $calendar): self
    {
        if ($this->calendar->contains($calendar)) {
            $this->calendar->removeElement($calendar);
            // set the owning side to null (unless already changed)
            if ($calendar->getStaticPage() === $this) {
                $calendar->setStaticPage(null);
            }
        }

        return $this;
    }

}
