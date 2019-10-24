<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Form;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EnrolmentRepository")
 */
class Enrolment
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $enrolledAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="enrolments")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EnrolmentEvent", inversedBy="enrolments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EnrolmentTime", inversedBy="enrolments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $time;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberOfPersons;

    /**
     * @ORM\Column(type="float")
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="boolean")
     */
    private $paid;

    /**
     * @ORM\Column(type="array")
     */
    private $inputData = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $message;

    public function __construct(EnrolmentEvent $event, User $user=null)
    {
        $this->uuid = bin2hex(random_bytes(12));
        $this->enrolledAt = new \DateTimeImmutable("now");
        $this->event = $event;
        $this->user = $user;
        $this->totalPrice = 0.;
        $this->paid = $event->isFreeOfCharge();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getEnrolledAt(): ?\DateTimeImmutable
    {
        return $this->enrolledAt;
    }

    public function getTime(): ?EnrolmentTime
    {
        return $this->time;
    }

    public function setTime(?EnrolmentTime $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getNumberOfPersons(): ?int
    {
        return $this->numberOfPersons;
    }

    public function setNumberOfPersons(int $numberOfPersons): self
    {
        $this->numberOfPersons = $numberOfPersons;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $this->event->getFreeOfCharge() ? true : $paid;

        return $this;
    }

    public function hasPaid(): ?bool
    {
        return $this->paid;
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

    public function getEvent(): ?EnrolmentEvent
    {
        return $this->event;
    }

/*
    public function setEvent(?EnrolmentEvent $event): self
    {
        $this->event = $event;

        return $this;
    }
*/

    public function getInputData(): ?array
    {
        return $this->inputData;
    }

    public function setInputData(array $inputData): self
    {
        $this->inputData = $inputData;

        return $this;
    }

    public function parseFormInputData(Form $form): self
    {
        $nofPersons = 0;
        $totalPrice = 0.;
        $inputData = [];

        foreach ( $this->event->getInputs() as $input ) {
            if ($number = $form->get($input->getSlug())->getData()) {
                $inputData[$input->getId()] = $number;
                $input->addTotalNumber($number);
                if ($input->hasUnitPrice()) $totalPrice += $number * $input->getUnitPrice();
                if ($input->getCategory()->isDefault()) $nofPersons += $number;
            } else {
                $inputData[$input->getId()] = 0;
            }
        }
        $this->inputData = $inputData;
        $this->parseInputData();

        $this->numberOfPersons = $nofPersons;
        $this->totalPrice = $totalPrice;

        $this->event->addNumberOfPersons($nofPersons);
        $this->event->addTotalPrice($totalPrice);

        $this->time->addNumberOfPersons($nofPersons);
        $this->time->addTotalPrice($totalPrice);


        return $this;
    }

    public function parseInputData(): self
    {
        $inputs = $this->event->getInputs();
        if ( count($inputs) != count($this->inputData) ) return $this;
        foreach ( $inputs as $input ) {
            $input->setNumber( $this->inputData[$input->getId()] );
        }
        return $this;
    }

    public function clearInputData(): self
    {
        $inputs = $this->event->getInputs();
        if ( count($inputs) != count($this->inputData) ) return $this;

        foreach ( $inputs as $input ) {
            $input->addTotalNumber(-$this->inputData[$input->getId()]);
        }

        $this->event->addNumberOfPersons(-$this->numberOfPersons);
        $this->event->addTotalPrice(-$this->totalPrice);

        $this->time->addNumberOfPersons(-$this->numberOfPersons);
        $this->time->addTotalPrice(-$this->totalPrice);

        $this->inputData = [];
        $this->numberOfPersons = 0;
        $this->totalPrice = 0.;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

}
