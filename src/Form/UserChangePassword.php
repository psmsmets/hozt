<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserChangePassword extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
                'label'    => false,
                'attr' => ['placeholder'=>'Huidig wachtwoord', 'class'=>'input-t'],
                'required' => true,
                ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => false,
                    'attr' => ['placeholder'=>'Nieuw wachtwoord', 'class'=>'input-m', 'pattern' => User::PASSWORD_REGEX],
                    'required' => true,
                    ),
                'second_options' => array(
                    'label' => false,
                    'attr' => ['placeholder'=>'Bevestig nieuw wachtwoord', 'class'=>'input-b'],
                    'required' => true,
                    ),
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
