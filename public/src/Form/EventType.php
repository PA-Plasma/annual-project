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
            ->add('address', CollectionType::class, [
                    // each entry in the array will be an "address" field
                    'entry_type' => AddressType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'prototype' => true,
                    'entry_options' => array('label' => false),
                ]
            )
//            ->add('entrants', TextType::class, [
//                'label' => 'Saisissez les joueurs que vous souhaitez inscrire'
//            ])
//            ->add('add_entrant', ButtonType::class, [
//                'attr' => ['id' => 'add_entrant'],
//                'label' => 'Inscrire un joueur'
//            ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
