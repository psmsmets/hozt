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

class UserEmailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentEmail', EmailType::class, array(
                'label'    => 'Huidig e-mail adres',
                'attr' => ['placeholder'=>'E-mail'],
                'required' => true,
                'mapped' => false,
                ))
            ->add('newEmail', EmailType::class, array(
                'label'    => 'Nieuw e-mail adres',
                'attr' => ['placeholder'=>'E-mail', 'class'=> 'mb-4'],
                'required' => true,
                'mapped' => false,
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
