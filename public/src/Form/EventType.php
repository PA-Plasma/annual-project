<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Modules;
use App\Repository\ModulesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * @var array $activeModules
     */
    private $activeModules;

    /**
     * UserType constructor
     *
     * @param ModulesRepository $modulesRepository
     */
    public function __construct(ModulesRepository $modulesRepository)
    {
        $this->activeModules = $modulesRepository->getActiveModules();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$options['entrants'] && !$options['back']) {
            $builder
                ->add('name', TextType::class, [
                    'label' => 'Event name:',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => 'Capcom Cup...'
                    ],
                ])
                ->add('beginnig_date', DateTimeType::class, [
                    'widget' => 'single_text',
                    'label' => 'Start date:',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('end_date', DateTimeType::class, [
                    'widget' => 'single_text',
                    'label' => 'End date:',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('registration_type', ChoiceType::class, [
                    'choices' => [
                        'Gratuit' => Event::REGISTRATION_TYPE_FREE,
                        'Payant' => Event::REGISTRATION_TYPE_PAYING,
                    ],
                    'required' => true,
                    'label' => 'Registration type:',
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('invitation', ChoiceType::class, [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false
                    ],
                    'required' => true,
                    'label' => 'Invitation',
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('address', AddressType::class, [
                    'label' => 'Address:',
                ])
                ->add('modules', EntityType::class, array(
                    'class' => Modules::class,
                    'query_builder' => $this->activeModules,
                    'label'    => 'Select which modules you want to enable: ',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ));
        } elseif (!$options['back']) {
            $builder->add('entrants', CollectionType::class, [
                    'entry_type' => EntrantType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            );
        } else {
            //back form
            $builder
                ->add('name', TextType::class, [
                    'label' => 'Event name:',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => 'Capcom Cup...'
                    ],
                ])
                ->add('beginnig_date', DateTimeType::class, [
                    'widget' => 'single_text',
                    'label' => 'Start date:',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('end_date', DateTimeType::class, [
                    'widget' => 'single_text',
                    'label' => 'End date:',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('registration_type', ChoiceType::class, [
                    'choices' => [
                        'Gratuit' => Event::REGISTRATION_TYPE_FREE,
                        'Payant' => Event::REGISTRATION_TYPE_PAYING,
                    ],
                    'required' => true,
                    'label' => 'Registration type:',
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('invitation', ChoiceType::class, [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false
                    ],
                    'required' => true,
                    'label' => 'Invitation',
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('address', AddressType::class, [
                    'label' => 'Address:',
                ])
                ->add('entrants', CollectionType::class, [
                    'entry_type' => EntrantType::class,
                    'entry_options' => ['label' => false],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
            'entrants' => false,
            'back' => false
        ]);
    }
}
