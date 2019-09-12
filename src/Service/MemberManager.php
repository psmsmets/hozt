<?php

namespace App\Service;

use App\Entity\Member;
use App\Entity\MemberAddress;
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

    public function createMember(
        int $memberId, string $firstname, string $lastname, string $gender, \DateTimeInterface $birthdate, 
        string $registrationId=null, \DateTimeInterface $since=null, MemberAddress $address=null, TrainingTeam $team=null 
    ): Member
    {
        if (!is_null($memberId)) {
            if ($this->memberRepository->findByMemberId($memberId)) $memberId = null;
        }
        if (is_null($memberId)) $memberId = $this->getLastMemberId()+1;

        $member = new Member($memberId);

        $member->setEnabled(false);
        $member->setFirstname($firstname);
        $member->setLastname($lastname);
        $member->setGender($gender);
        $member->setBirthdate($birthdate);
        $member->setRegistrationId($registrationId);
        $member->setMemberSince($since);

        if ($address) $member->setAddress($address);
        if ($team) $member->setTeam($team);

        return $member;
    }

    public function findMember(int $memberId, string $firstname, string $lastname, string $gender, \DateTimeInterface $birthdate): ?Member
    {
        if ($member = $this->memberRepository->findByMemberId($memberId)) return $member;
        //if ($member = $this->memberRepository->findBySpecs($firstname,$lastname,$gender,$birthdate)) return $member;

        return null;
    }

    public function createAddress(string $street, string $zip, string $town, string $nation, User $user=null): MemberAddress
    {
        $address = new MemberAddress($user);

        $address->setStreet($street);
        $address->setZip($zip);
        $address->setTown($town);
        $address->setNation($nation);

        return $address;
    }

    public function getLastMemberId(): int
    {
        $memberId = $this->memberRepository->getLastMemberId();
        return is_null($memberId) ? 0 : $memberId;
    }

    public function export2assist(string $separator = ';', string $dateFormat = 'd-m-Y')
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
