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

class UserPreferences extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', PasswordType::class, array(
                'label'    => false,
                'attr' => ['placeholder'=>'Wachtwoord'],
                'required' => true,
                ))
            ->add('firstname', TextType::class, array(
                'label'    => 'Voornaam',
                'attr' => ['placeholder'=>'Voornaam'],
                'required' => true,
                ))
            ->add('lastname', TextType::class, array(
                'label'    => 'Naam',
                'attr' => ['placeholder'=>'Naam'],
                'required' => true,
                ))
            ->add('email', EmailType::class, array(
                'label'    => false,
                'attr' => ['placeholder'=>'E-mail'],
                'required' => true,
                ))
            ->add('telephone', TextType::class, array(
                'label'    => 'Mobiele telefoon',
                'help'    => 'Enkel een Belgisch of Nederlands telefoonnummer beginnende met de landcode',
                'attr' => ['placeholder'=>'+324...','pattern'=>$this->params->get('app.regex.mobile')],
                'required' => true,
                ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => User::class,
        ]);
    }
}
