<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (!$options['entrants']) {
            $builder
                ->add('name', TextType::class, [
                    'required' => true,
                    'label' => 'Nom de l\'événement'
                ])
                ->add('beginnig_date', DateType::class, [
                    'widget' => 'single_text',
                    'required' => true,
                    'label' => 'Date de début'
                ])
                ->add('end_date', DateType::class, [
                    'widget' => 'single_text',
                    'required' => true,
                    'label' => 'Date de fin'
                ])
                ->add('registration_type', ChoiceType::class, [
                    'choices' => [
                        'Gratuit' => Event::REGISTRATION_TYPE_FREE,
                        'Payant' => Event::REGISTRATION_TYPE_PAYING,
                    ],
                    'label' => 'Type d\'inscription'
                ])
                ->add('invitation', ChoiceType::class, [
                    'choices' => [
                        'Oui' => true,
                        'Non' => false
                    ],
                    'label' => 'Invitation'
                ])
                ->add('address', AddressType::class)
            ;
        } else {
            $builder->add('entrants', CollectionType::class, [
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
            'entrants' => false
        ]);
    }
}
