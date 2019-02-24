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
                'label' => 'Bracket type:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Bracket type'
                ],
                'choices' => [
                    'Choix 1' => ModuleTournamentParameters::BRACKET_TYPE_1,
                    'Choix 2' => ModuleTournamentParameters::BRACKET_TYPE_2,
                ]
            ])
            ->add('stageType', ChoiceType::class, [
                'label' => 'Stage type:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Bracket type'
                ],
                'choices' => [
                    'Choix 1' => ModuleTournamentParameters::STAGE_TYPE_1,
                    'Choix 2' => ModuleTournamentParameters::STAGE_TYPE_2,
                ]
            ])
            ->add('playerFormatDefault', ChoiceType::class, [
                'label' => 'Stage type:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Bracket type'
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