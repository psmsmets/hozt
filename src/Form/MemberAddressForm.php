<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Member;
use App\Entity\MemberAddress;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MemberAddressForm extends AbstractType
{

    private $params;
    private $security;

    public function __construct(ParameterBagInterface $params, Security $security)
    {
        $this->params = $params;
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', TextType::class, array(
                'label'    => 'address.streetnumber',
                'required' => true,
                ))
            ->add('zip', TextType::class, array(
                'label'    => 'address.zip',
                'attr' => ['pattern'=>$this->params->get('app.regex.zip')],
                'required' => true,
                ))
            ->add('town', TextType::class, array(
                'label'    => 'address.town',
                'required' => true,
                ))
            ->add('nation', CountryType::class, array(
                'label'    => 'address.nation',
                'attr' => ['class'=>'custom-select'],
                'preferred_choices' => ['BE','NL'],
                'required' => true,
                ))
            ->add('members', EntityType::class, array(
                'class' => Member::class,
                'choice_loader' => new CallbackChoiceLoader(function() {
                    $user = $this->security->getUser();
                    return $user instanceof User ? $user->getMembers() : null; 
                 }),
                'label'    => 'address.member',
                'multiple' => true,
                'expanded' => true,
                'required' => false,
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => MemberAddress::class,
        ]);
    }
}
