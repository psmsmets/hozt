<?php

namespace App\Service;

use App\Entity\Member;
use App\Entity\User;
use App\Entity\TrainingTeam;
use App\Repository\MemberRepository;
use Doctrine\ORM\EntityManagerInterface;

class MemberManager 
{
    private $entityManager;
    private $memberRepository;

    public function __construct(EntityManagerInterface $entityManager, MemberRepository $memberRepository )
    {
        $this->entityManager = $entityManager;
        $this->memberRepository = $memberRepository;
    }

    public function create(string $firstname, string $lastname, TrainingTeam $team=null, int $memberId=null, User $user=null )
    {
        // create a new member
        if (!is_null($memberId)) {
            if ($this->memberRepository->findByMemberId($memberId)) $memberId = null;
        }
        if (is_null($memberId)) $memberId = $this->memberRepository->getLastMemberId()+1;

        $member = new Member($memberId);

        $member->setFirstname($firstname);
        $member->setLastname($lastname);
        $member->setUser($user);
        $member->setTeam($team);

        $this->entityManager->persist($member);
        $this->entityManager->flush();

    }

    public function export2assist( string $separator = ';', string $dateFormat = 'd-m-Y' )
    {
            $fields = array( 
                'FIRSTNAME' => 'member.firstname', 
                'LASTNAME' => 'member.lastname', 
                'GENDER' => 'member.gender', 
                'BIRTHDATE' => 'member.birthdate', 
                'NATION' => 'member.nation', 
                'STREET' => 'member.street', 
                'ZIP' => 'member.zip', 
                'PLACE' => 'member.place', 
                'PHONEP' => '',
                'MOBILE' => 'user.mobilephone', 
                'EMAIL' => 'user.email', 
                'REGISTRATIONID' => 'member.registrationID', 
                'CLUBCODE' => '%app.about.code%', 
                'GROUPS' => '',
            );

    }

}
