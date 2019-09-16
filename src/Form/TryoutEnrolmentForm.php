<?php

namespace App\Form;

use Eo\HoneypotBundle\Form\Type\HoneypotType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use App\Entity\TrainingTeamCategory;
use App\Entity\Tryout;
use App\Entity\TryoutEnrolment;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TryoutEnrolmentForm extends AbstractType
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
                'attr' => ['placeholder'=>'Naam'],
                'required' => true,
                ))
            ->add('email', RepeatedType::class, array(
                'type' => EmailType::class,
                'first_options' => array(
                    'label'    => 'E-mail adres',
                    'attr' => ['placeholder'=>'E-mail'],
                    'required' => true,
                    ),
                'second_options' => array(
                    'label' => false,
                    'attr' => ['placeholder'=>'Bevestig e-mail'],
                    'required' => true,
                    ),
                ))
            ->add('telephone', TextType::class, array(
                'label'    => 'Mobiele telefoon',
                'help'    => 'Enkel een Belgisch of Nederlands telefoonnummer beginnende met de landcode',
                'attr' => ['placeholder'=>'+324...','pattern'=>$this->params->get('app.regex.mobile')],
                'required' => true,
                ))
            ->add('birthdate', DateType::class, array(
                'label'    => 'Geboortedatum',
                 'widget' => 'choice',
                 'years' => range(date('Y')-5, date('Y')-85),
                 #'months' => range(1, 12),
                 #'days' => array(range(1, 31),
                 #'attr' => ['class'=>'custom-select'],
                 #'help'    => 'dag/maand/jaar',
                 #'attr' => ['placeholder'=>'1/1/2016','pattern'=>$this->params->get('app.regex.datestring')],
                'required' => true,
                ))
            ->add('address', TextType::class, array(
                'label'    => 'Postcode',
                'attr' => ['placeholder'=>'2320','pattern'=>$this->params->get('app.regex.zip')],
                'required' => true,
                ))
            ->add('tryout', EntityType::class, array(
                'class' => Tryout::class,
                'choice_label' => 'getFormattedPeriod',
                'query_builder' => function (EntityRepository $er) {
                    $now = new \DateTime('now');
                    return $er->createQueryBuilder('tryout')
                        ->where('tryout.enabled = :enabled')
                        ->andwhere('tryout.enrolFrom < :now')
                        ->andwhere(':now <= tryout.startTime')
                        ->setParameter('enabled', true)
                        ->setParameter('now', $now->format('Y-m-d H:i'))
                        ->orderBy('tryout.startTime', 'ASC')
                        ;
                },
                'choice_attr' => function($choice) {
                    $now = new \DateTime('now');
                    return ['disabled' => ($choice->getRemainingEnrolments()==0 or $now > $choice->getEnrolUntil())];
                },
                'label'    => 'Kies een testmoment',
                'attr' => ['class'=>'custom-select'],
                'required' => true,
                'placeholder' => '-- Maak een keuze --',
                ))
            ->add('category', EntityType::class, array(
                'class' => TrainingTeamCategory::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('trainingCategory')
                        ->where('trainingCategory.enabled = :enabled')
                        ->setParameter('enabled', true)
                        ->orderBy('trainingCategory.sequence', 'ASC')
                        ;
                },
                'label'    => 'Voor welk groep wil je testen?',
                'attr' => ['class'=>'custom-select'],
                'required' => true,
                'placeholder' => '-- Maak een keuze --',
                ))
            ->add('message', TextareaType::class, array(
                'label'    => 'Heb je een vraag of wil je nog iets kwijt?',
                'attr' => ['rows'=>8],
                'required' => false,
                ))
            ->add('terms', CheckboxType::class, array(
                'label'    => 'Privacybeleid',
                'required' => true,
                'mapped' => false,
                ))
            // Honeypot field
            ->add('Straat', HoneypotType::class);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'data_class' => TryoutEnrolment::class,
        ]);
    }
}
