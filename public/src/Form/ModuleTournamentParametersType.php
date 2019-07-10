<?php

namespace App\Form;

use App\Entity\Modules\ModuleTournamentParameters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleTournamentParametersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bracketType', ChoiceType::class, [
                'label' => 'Type de tournoi:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'choices' => [
                    'Par équipe' => ModuleTournamentParameters::BRACKET_TYPE_1,
                    'Battle royal' => ModuleTournamentParameters::BRACKET_TYPE_2,
                ]
            ])
            ->add('stageType', ChoiceType::class, [
                'label' => 'Type de match:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'choices' => [
                    'Normal' => ModuleTournamentParameters::STAGE_TYPE_1,
                    'Aller-retour' => ModuleTournamentParameters::STAGE_TYPE_2,
                ]
            ])
            ->add('playerFormatDefault', ChoiceType::class, [
                'label' => 'Type d\'affrontement:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
                'choices' => [
                    'BO3' => ModuleTournamentParameters::BO3,
                    'BO5' => ModuleTournamentParameters::BO5,
                    'BO7' => ModuleTournamentParameters::BO7,
                ]
            ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-md btn-primary mt-1 save'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModuleTournamentParameters::class,
        ]);
    }
}