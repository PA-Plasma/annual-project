<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Modules;
use App\Repository\ModulesRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
                    'label' => 'Nom:',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => 'Capcom Cup...'
                    ],
                ])
                ->add('description', TextareaType::class, [
                    'label' => 'Déscription:',
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => 'Beautiful and free LAN in Paris...'
                    ],
                ])
                ->add('beginnig_date', DateTimeType::class, [
                    'widget' => 'single_text',
                    'label' => 'Date de début:',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('end_date', DateTimeType::class, [
                    'widget' => 'single_text',
                    'label' => 'Date de fin:',
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
                    'label' => 'Type d\'inscription:',
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('price', MoneyType::class, [
                    'required' => false,
                    'label' => 'Prix:',
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => '12'
                    ],
                ])
                ->add('cashprice_type', ChoiceType::class, [
                    'choices' => [
                        'Sans' => Event::CASHPRICE_TYPE_WITHOUT,
                        'Pour les 3 premières places' => Event::CASHPRICE_TYPE_WITH,
                    ],
                    'required' => true,
                    'label' => 'Type de récompenses:',
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('cashprice1', MoneyType::class, [
                    'required' => false,
                    'label' => 'Gagnant',
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => '1000'
                    ],
                ])
                ->add('cashprice2', MoneyType::class, [
                    'required' => false,
                    'label' => 'Deuxième place',
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => '800'
                    ],
                ])
                ->add('cashprice3', MoneyType::class, [
                    'required' => false,
                    'label' => 'Troisième place',
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => '500'
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
                ->add('address', AddressType::class)
                ->add('modules', EntityType::class, [
                    'class' => Modules::class,
                    'query_builder' => $this->activeModules,
                    'label'    => 'Sélectionner les modules à activer:',
                    'choice_label' => 'name',
                    'multiple' => true,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('imageFile', VichImageType::class, [
                    'required' => false,
                    'label'             => 'Image (.jpg, .png ou .gif)',
                    'download_link'     => false,
                    'delete_label'          => 'Supprimer l\'image ?'
                ]);

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
                    'label' => 'Nom:',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => 'Capcom Cup...'
                    ],
                ])
                ->add('beginnig_date', DateTimeType::class, [
                    'widget' => 'single_text',
                    'label' => 'Date de début:',
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ])
                ->add('end_date', DateTimeType::class, [
                    'widget' => 'single_text',
                    'label' => 'Date de fin:',
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
                    'label' => 'Type d\'inscription:',
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
                ->add('address', AddressType::class)
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
