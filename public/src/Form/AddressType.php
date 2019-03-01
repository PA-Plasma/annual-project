<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', TextType::class, [
                'label' => 'Number:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => '99'
                ],
            ])
            ->add('road', TextType::class, [
                'label' => 'Street:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Rue de Rivoli'
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'City:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'Paris'
                ],
            ])
            ->add('city_code', TextType::class,[
                'label' => 'Zipcode:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => '75004'
                ],
            ])
            ->add('country', TextType::class,[
                'label' => 'Country:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'France'
                ],
            ])
            ->add('complement', TextareaType::class, [
                'label' => 'Address supplement:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-4',
                    'placeholder' => 'Some stuff...'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
