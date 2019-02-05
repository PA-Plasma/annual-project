<?php

namespace App\Form;

use App\Entity\Modules;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModulesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Custom module'
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'This is a module that...'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Modules::class,
        ]);
    }
}
