<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UserNameForm extends AbstractType
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array(
                'label'    => 'Voornaam',
                'attr' => ['placeholder'=>'Voornaam'],
                'required' => true,
                ))
            ->add('lastname', TextType::class, array(
                'label'    => 'Naam',
                'attr' => ['placeholder'=>'Naam', 'class'=>'mb-4'],
                'required' => true,
                ))
            ->add('plainPassword', PasswordType::class, array(
                'label'    => 'Bevestig met je wachtwoord',
                'attr' => ['placeholder'=>'Wachtwoord'],
                'required' => true,
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
