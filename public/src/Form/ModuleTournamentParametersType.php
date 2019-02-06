<?php

namespace App\Form;

use App\Entity\Modules\ModuleTournamentParameters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModuleTournamentParameters::class,
        ]);
    }
}