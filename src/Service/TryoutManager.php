<?php

namespace App\Service;

use App\Entity\Tryout;
use App\Entity\TryoutEnrolment;
use App\Repository\TryoutRepository;
use App\Repository\TryoutEnrolmentRepository;
use Doctrine\ORM\EntityManagerInterface;

class TryoutManager 
{
    private $em;
    private $tryoutRepository;

    public function __construct(EntityManagerInterface $em, TryoutRepository $tr, TryoutEnrolmentRepository $ter, \Swift_Mailer $mailer)
    {
        $this->em = $em;
        $this->tr = $tr;
        $this->ter = $ter;
        $this->mailer = $mailer;
    }

    public function add_enrolment( TryoutEnrolment $enrol, bool $notify = true )
    {

    }

    public function withdraw_enrolment( TryoutEnrolment $enrol, bool $notify = true )
    {

    }

    public function reminders( Tryout $tryout )
    {

    }

    public function mail_enrolment( TryoutEnrolment $enrol, bool $force = false )
    {

    }

    public function mail_withdrawal( TryoutEnrolment $enrol, bool $force = false )
    {

    }

    public function mail_reminder( TryoutEnrolment $enrol, bool $force = false )
    {

    }
}
