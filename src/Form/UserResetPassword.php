<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

//use Doctrine\ORM\EntityRepository;
//use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class UserResetPassword extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array(
                    'label' => false,
                    'attr' => ['placeholder'=>'Nieuw wachtwoord', 'class'=>'input-t', 'pattern' => User::PASSWORD_REGEX],
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
