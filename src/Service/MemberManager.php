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
    private $em;
    private $memberRepository;

    public function __construct(EntityManagerInterface $em, MemberRepository $memberRepository )
    {
        $this->em = $em;
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

    public function findMemberById(int $memberId): ?Member
    {
        return $this->memberRepository->findByMemberId($memberId);
    }

    public function findMemberBySpecs(string $firstname, string $lastname, string $gender, \DateTimeInterface $birthdate): ?Member
    {
        return $this->memberRepository->findBySpecs($firstname,$lastname,$gender,$birthdate);
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

    public function setAddressUser(Member $member, bool $flush=true)
    {
        $address = $member->getAddress();
        $address->setUser($member->getUser());

        if ($flush) $this->em->flush();
    }

    public function setAddress(MemberAddress $address, bool $flush=true)
    {
        foreach($address->getMembers() as $member) {
            $member->setAddress($address);
        }
        if ($flush) $this->em->flush();
    }

    public function removeOrphantAddresses (User $user, bool $flush=true)
    {
        foreach($user->getOrphantMemberAddresses() as $address) {
            $this->em->remove($address);
        }
        if ($flush) $this->em->flush();
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
