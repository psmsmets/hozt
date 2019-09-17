<?php

namespace App\Form;

use App\Entity\UserDetails;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserDetailsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('secondaryEmail', EmailType::class, array(
                'label'    => false,
                'attr' => ['placeholder'=>'E-mail'],
                'required' => false,
                ))
            ->add('notificationDays', ChoiceType::class, array(
                'label'    => 'Notificatie dagen',
                'required' => true,
                'multiple' => true,
                'choices' => range(1,7),
                'choice_label' => function ($choice, $key, $value) {
                    return jddayofweek($key,$mode=1);
                },
                //'choice_translation_domain' => true,
                ))
            ->add('reminderOffset', ChoiceType::class, array(
                'label'    => 'Stuur een wedstrijd herinnering ... dag(en) vooraf',
                'attr' => ['class'=> 'custom-select'],
                'required' => true,
                'choices' => range(UserDetails::minReminderOffset,UserDetails::maxReminderOffset),
                'choice_label' => function ($choice, $key, $value) {
                    return $value;
                },
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
