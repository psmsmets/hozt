<?php

namespace App\Form;

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
                'help' => 'We houden al jouw gegevens strikt én met zorg voor onszelf.',
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
                'attr' => ['placeholder'=>'+324...','pattern'=>$this->params->get('app.regex.telephone')],
                'required' => true,
                ))
            ->add('birthdate', DateType::class, array(
                'label'    => 'Geboortedatum',
                 'widget' => 'choice',
                 'years' => range(date('Y')-5, date('Y')-80),
                 #'months' => range(1, 12),
                 #'days' => range(1, 31),
                'required' => true,
                ))
            ->add('address', TextType::class, array(
                'label'    => 'Postcode',
                'attr' => ['placeholder'=>'2320','pattern'=>$this->params->get('app.regex.postalcode')],
                'required' => true,
                ))
            ->add('tryout', EntityType::class, array(
                'class' => Tryout::class,
                'query_builder' => function (EntityRepository $er) {
                    $today = new \DateTime('today');
                    return $er->createQueryBuilder('c')
                        ->where('c.enabled = :enabled')
                        ->andwhere('c.startTime < :today')
                        ->setParameter('enabled', true)
                        ->setParameter('today', $today->format('Y-m-d  H:M'))
                        ->orderBy('c.startTime', 'ASC')
                        ;
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
                    return $er->createQueryBuilder('c')
                        ->where('c.enabled = :enabled')
                        ->setParameter('enabled', true)
                        ->orderBy('c.sequence', 'ASC')
                        ;
                },
                'label'    => 'Voor welk zwemniveau wil je testen?',
                'attr' => ['class'=>'custom-select'],
                'required' => true,
                'placeholder' => '-- Maak een keuze --',
                ))
            ->add('message', TextareaType::class, array(
                'label'    => 'Heb je een vraag of wil je nog iets kwijt?',
                'attr' => ['rows'=>8],
                'required' => false,
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
