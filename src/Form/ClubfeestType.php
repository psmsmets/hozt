<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Clubfeest;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ClubfeestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('children', IntegerType::class, array(
                'label'    => 'Aantal -12 jaar',
                'attr' => ['value'=>'0','min'=>0,'max'=>10],
                'required' => true,
                ))
            ->add('adults', IntegerType::class, array(
                'label'    => 'Aantal 12 jaar en ouder',
                'attr' => ['value'=>'0','min'=>0,'max'=>10],
                'required' => true,
                ))
            ->add('name', TextType::class, array(
                'label'    => 'Je naam',
                'attr' => ['placeholder'=>'Naam'],
                'required' => true,
                ))
            ->add('email', EmailType::class, array(
                'label'    => 'Je e-mail adres',
                'attr' => ['placeholder'=>'E-mail'],
                'help' => 'We houden je e-mail adres strikt voor onszelf.',
                'required' => true,
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
            'data_class' => TryoutEnrolment::class,
        ]);
    }
}
