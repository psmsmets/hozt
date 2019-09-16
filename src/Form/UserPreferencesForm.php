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

class UserPreferencesForm extends AbstractType
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', PasswordType::class, array(
                'label'    => 'Wachtwoord',
                'attr' => ['placeholder'=>'Wachtwoord', 'class'=> 'mb-4'],
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
            ->add('currentEmail', EmailType::class, array(
                'label'    => 'E-mail adres',
                'attr' => ['placeholder'=>'Huidig e-mail adres'],
                'required' => false,
                'mapped' => false,
                ))
            ->add('newEmail', EmailType::class, array(
                'label'    => false,
                'attr' => ['placeholder'=>'Nieuw e-mail adres'],
                'required' => false,
                'mapped' => false,
                ))
            ->add('currentMobilephone', TextType::class, array(
                'label'    => 'Mobiele telefoon',
                //'help'    => 'Enkel een Belgisch of Nederlands telefoonnummer beginnende met de landcode',
                'attr' => ['placeholder'=>'Huidige mobiele telefoon','pattern'=>$this->params->get('app.regex.mobile')],
                'required' => false,
                'mapped' => false,
                ))
            ->add('newMobilephone', TextType::class, array(
                'label'    => false,
                'help'    => 'Enkel een Belgisch of Nederlands telefoonnummer beginnende met de landcode (+324... of +316...)',
                'attr' => ['placeholder'=>'Nieuwe mobiele telefoon','pattern'=>$this->params->get('app.regex.mobile')],
                'required' => false,
                'mapped' => false,
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
