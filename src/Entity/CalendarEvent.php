<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=128, unique=true)
     */
    private $uuid;

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
    private $cancelled;

    /**
     * @ORM\Column(type="boolean")
     */
    private $eventIsCompetition;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document;

    /**
     * @Vich\UploadableField(mapping="blogPost_documents", fileNameProperty="document")
     * @var File
     */
    private $documentFile;

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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BlogPost", mappedBy="event")
     */
    private $posts;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\StaticPage", inversedBy="calendar")
     */
    private $staticPage;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\EnrolmentEvent", mappedBy="calendar")
     */
    private $enrolmentEvent;

    public function __construct()
    {
        $this->uuid = bin2hex(random_bytes(8));
        $this->createdAt = new \DateTime("now");
        $this->updatedAt = $this->createdAt;
        $this->startTime = new \DateTime("today noon"); 
        $this->endTime = new \DateTime("today noon");
        $this->allDay = true;
        $this->enabled = false;
        $this->archived = false;
        $this->cancelled = false;
        $this->eventIsCompetition = true;
        $this->posts = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        return $this->startTime->format('Y-m-d') . " (" . $this->title . ")";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
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

    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        if (!$this->enabled) $this->enabled = $enabled;

        return $this;
    }

    public function getDraft(): ?bool
    {
        return !$this->enabled;
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

    public function getCancelled(): ?bool
    {
        return $this->cancelled;
    }

    public function setCancelled(bool $cancelled): self
    {
        $this->cancelled = $cancelled;

        return $this;
    }

    public function getEventIsCompetition(): ?bool
    {
        return $this->eventIsCompetition;
    }

    public function setEventIsCompetition(bool $eventIsCompetition): self
    {
        $this->eventIsCompetition = $eventIsCompetition;

        return $this;
    }

    public function getStartTime(): ?\DateTimeInterface
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeInterface $startTime): self
    {
        if ($this->hasCompetition()) {
            $start = $this->competition->getFirstDayCompetitionParts();
            if (!is_null($start)) {
                if ($startTime > $start->modify('+1day -1sec')) return $this;
            }    
        }
        $this->startTime = $startTime;

        return $this;
    }

    public function trueStartTime(): \DateTimeInterface
    {
        if ($this->allDay) {

            $begin = clone $this->startTime;
            return $begin->setTime(0, 0, 0);

        } else {

            return $this->startTime;

        }
    }

    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(?\DateTimeInterface $endTime): self
    {
        if ($this->hasCompetition()) {
            $end = $this->competition->getLastDayCompetitionParts();
            if (!is_null($end)) {
                if ($endTime < $end) return $this;
            }    
        }
        $this->endTime = $endTime;

        return $this;
    }

    public function trueEndTime(): \DateTimeInterface
    {
        if (!is_null($this->endTime) and !$this->allDay ) {

            return $this->endTime;

        } else {

            if (is_null($this->endTime)) {

                $end = clone $this->startTime;

            } else {

                $end = clone $this->endTime;

            }

            return $end->setTime(23, 59, 59);

        }
    }

    public function calcEndTime(): \DateTimeInterface
    {
        return $this->trueEndTime();
    }

    public function isFuture(): ?bool
    {
        return new \DateTime("now") < $this->startTime;
    }

    public function isPast(): ?bool
    {
        return new \DateTime("now") > $this->trueEndTime();
    }

    public function isOngoing(): ?bool
    {
        return !$this->isFuture() && !$this->isPast();
    }

    public function getStatus(): ?string
    {
        if ($this->isFuture()) return 'future';
        if ($this->isPast()) return 'past';
        return 'ongoing';
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
        return strftime('%B', $this->trueEndTime()->getTimestamp());
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

    public function getNumberOfDays(): int
    {
        $start = (clone $this->startTime)->modify('midnight');
        $end = (clone $this->calcEndTime())->modify('midnight');

        return (int) $start->diff($end)->format('%d') + 1;
    }

    public function getListOfDays(): ?array
    {
        $daylist = array();
        $day = \DateTimeImmutable::createFromMutable($this->startTime)->modify('midnight');

        $numberOfDays = $this->getNumberOfDays();
        if ($numberOfDays > 30) $numberOfDays = 30;

        for ($d=0; $d<$numberOfDays; $d++)
        {
            $daylist[] = $day->modify("+$d days");
        }

        return $daylist;
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

    public function setUrl(?string $url): self
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

    public function hasCompetition(): ?bool
    {
        return !is_null($this->competition);
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(BlogPost $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setEvent($this);
        }

        return $this;
    }

    public function removePost(BlogPost $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getEvent() === $this) {
                $post->setEvent(null);
            }
        }

        return $this;
    }

    public function getStaticPage(): ?StaticPage
    {
        return $this->staticPage;
    }

    public function setStaticPage(?StaticPage $staticPage): self
    {
        $this->staticPage = $staticPage;

        return $this;
    }

    public function getEnrolmentEvent(): ?EnrolmentEvent
    {
        return $this->enrolmentEvent;
    }

    public function setEnrolmentEvent(?EnrolmentEvent $enrolmentEvent): self
    {
        $this->enrolmentEvent = $enrolmentEvent;

        // set (or unset) the owning side of the relation if necessary
        $newCalendar = $enrolmentEvent === null ? null : $this;
        if ($newCalendar !== $enrolmentEvent->getCalendar()) {
            $enrolmentEvent->setCalendar($newCalendar);
        }

        return $this;
    }

    public function hasEnrolmentEvent(): ?bool
    {
        return !is_null($this->enrolmentEvent);
    }

    public function hasEnabledEnrolmentEvent(): ?bool
    {
        if (!$this->hasEnrolmentEvent()) return false;
        return $this->enrolmentEvent->isEnabled();
    }

}
