<?php

namespace App\Form;

use App\Entity\Enrolment;
use App\Entity\EnrolmentTime;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

use Twig\Environment;

class EnrolmentForm extends AbstractType
{

    private $twig;

    public function __construct( Environment $twig )
    {
        $this->twig = $twig;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {

            $money_fmt = new \NumberFormatter('nl',\NumberFormatter::CURRENCY);

            $enrolment = $event->getData();
            $form = $event->getForm();

            $nameOptions = [
                'label'    => 'Je naam',
                'attr' => ['placeholder'=>'Naam'],
                'required' => true,
            ];

            $emailOptions = [
                'label'    => 'Je e-mail adres',
                'attr' => ['placeholder'=>'E-mail'],
                'help' => 'We houden je e-mail adres strikt voor onszelf.',
                'required' => true,
            ];

            if ($user = $enrolment->getUser()) {
                $nameOptions['data'] = $user->getName();
                $emailOptions['data'] = $user->getEmail();
            }

            $form
                ->add('name', TextType::class, $nameOptions)
                ->add('email', EmailType::class, $emailOptions)
                ->add('time', EntityType::class, array(
                    'class' => EnrolmentTime::class,
                    'query_builder' => function (EntityRepository $er) {
                        $now = new \DateTime('today');
                        return $er->createQueryBuilder('time')
                            ->andwhere(':now <= time.startTime')
                            ->setParameter('now', $now)
                            ->orderBy('time.startTime', 'ASC')
                            ;
                    },
                    'choice_attr' => function($choice) {
                        return ['disabled' => ( $choice->getStrictNumberOfPersonsLimit() and $choice->getRemainingNumberOfPersons() <= 0 )];
                    },
                    'label'    => 'Kies een tijdstip',
                    'attr' => ['class'=>'custom-select'],
                    'required' => true,
                    'placeholder' => '-- Maak een keuze --',
                    ))
            ;
            $inputCategoryId = 0;
            foreach ( $enrolment->getEvent()->getInputs() as $input ) {

                $category = $input->getCategory();
                $formOptions = [
                    'label'    => $this->twig->render('enrolment/formatter/enrolmentInput_label.html.twig', ['enrolmentInput'=>$input]),
                    'required' => true,
                    'mapped' => false,
                    'attr' => [
                        'placeholder' => $input->getName().'?',
                        'data-category-type' => $category->getTypeName(), 
                        'data-value' => $input->getUnitPrice(),
                        'min' =>  $category->isDefault() ? 1 : 0,
                    ],
                ];
                if ($category->isIncluded()) $formOptions['attr']['max'] = 0;
                if (!is_null($input->getDescription())) $formOptions['help'] = $input->getDescription();

                if ($inputCategoryId !== $input->getCategory()->getId() ) {
                    if ($category->getShowTitle()) $formOptions['attr']['data-category-title'] = $category->getTitle();
                    if ($category->getShowDescription()) $formOptions['attr']['data-category-description'] = $category->getDescription();
                    $inputCategoryId = $category->getId();
                }

                $form->add($input->getSlug(), IntegerType::class, $formOptions);

            }

            if (!$enrolment->getEvent()->isFreeOfCharge()) {
                $form
                    ->add('totalPrice', MoneyType::class, array(
                        'label'    => 'Te betalen',
                        'attr' => ['data-parent-parent-class'=>'mt-5 pt-3 pb-4 mb-3 border-top border-bottom'],
                        'required' => true,
                        'disabled' => true,
                        ))
                ;
            }

            $form
                ->add('message', TextareaType::class, array(
                    'label'    => 'Heb je een vraag of wil je nog iets kwijt?',
                    'attr' => ['rows'=>4,'data-parent-class'=>'pt-4'],
                    'required' => false,
                    ))
            ;

        });

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Enrolment::class,
        ]);
    }
}
