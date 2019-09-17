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

class UserMobilephoneForm extends AbstractType
{
    private $params;

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentMobilephone', TextType::class, array(
                'label'    => 'Huidige mobiele telefoon',
                //'help'    => 'Enkel een Belgisch of Nederlands nummer beginnende met de landcode',
                'attr' => ['placeholder'=>'+324... of +316...','pattern'=>$this->params->get('app.regex.mobile')],
                'required' => true,
                'mapped' => false,
                ))
            ->add('newMobilephone', TextType::class, array(
                'label'    => 'Nieuwe mobiele telefoon',
                'help'    => 'Enkel een Belgisch of Nederlands nummer beginnende met de landcode',
                'attr' => ['placeholder'=>'+324... of +316...','pattern'=>$this->params->get('app.regex.mobile')],
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
