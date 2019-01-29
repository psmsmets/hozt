<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CalendarEventRepository")
 * @Vich\Uploadable
 */
class CalendarEvent
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
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archived;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isCompetition;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startTime;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endTime;

    /**
     * @ORM\Column(type="boolean")
     */
    private $allDay;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $location;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="carousel_images", fileNameProperty="image")
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CalendarCategory", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Competition", mappedBy="calendar", cascade={"persist", "remove"})
     */
    private $competition;

    public function __construct()
    {
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->startTime = new \DateTime("today noon"); 
        $this->endTime = null;
        $this->allDay = false;
        $this->enabled = true;
        $this->archived = false;
        $this->isCompetition = false;
    }

    public function __toString(): ?string
    {
        return $this->startTime->format('Y-m-d') . " (" . $this->title . ")";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

/*
https://github.com/ramsey/uuid-doctrine/issues/13
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }
*/

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getArchived(): ?bool
    {
        return $this->archived;
    }

    public function setArchived(bool $archived): self
    {
        $this->archived = $archived;

        return $this;
    }

    public function getIsCompetition(): ?bool
    {
        return $this->isCompetition;
    }

    public function setIsCompetition(bool $isCompetition): self
    {
        $this->isCompetition = $isCompetition;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function calcEndTime(): \DateTimeInterface
    {
        if (is_null($this->endTime)) {
            $begin = clone $this->startTime;
            return $begin->setTime(23, 59, 59);
        } else {
            return $this->endTime;
        }
    }

    public function isSameDay(): ?bool
    {
        return is_null($this->endTime)? true : $this->startTime->format('Y-m-d') == $this->endTime->format('Y-m-d');
    }

    public function getFormattedPeriod(): ?string
    {
        $fmt = "%A %e %B %Y";
        if (is_null($this->endTime)) {
            return strftime($this->allDay ? $fmt : $fmt.' vanaf %H:%M', $this->startTime->getTimestamp());
        } else {
            if ($this->isSameDay()) {
                return strftime($fmt.' van %H:%M', $this->startTime->getTimestamp()).strftime(' tot %H:%M', $this->endTime->getTimestamp());
            } else {
                $fmt = $this->allDay ? $fmt : $fmt . ' %H:%M';
                return strftime($fmt, $this->startTime->getTimestamp()).strftime(' tot '.$fmt, $this->endTime->getTimestamp());
            }
        }
    }

    public function getFormattedMonth(): ?string
    {
        return strftime('%B', $this->calcEndTime()->getTimestamp());
    }

    public function getAllDay(): ?bool
    {
        return $this->allDay;
    }

    public function setAllDay(bool $allDay): self
    {
        $this->allDay = $allDay;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

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

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function getCategory(): ?CalendarCategory
    {
        return $this->category;
    }

    public function setCategory(?CalendarCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(Competition $competition): self
    {
        $this->competition = $competition;

        // set the owning side of the relation if necessary
        if ($this !== $competition->getCalendar()) {
            $competition->setCalendar($this);
        }

        return $this;
    }

}
