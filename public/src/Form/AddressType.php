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
                'label' => 'Numéro'
            ])
            ->add('road', TextType::class, [
                'label' => 'Rue'
            ])
            ->add('city', TextType::class, [
                'required' => true,
                'label' => 'Ville'
            ])
            ->add('city_code', TextType::class,[
                'required' => true,
                'label' => 'Code postal'
            ])
            ->add('country', TextType::class,[
                'required' => true,
                'label' => 'Pays'
            ])
            ->add('complement', TextareaType::class, [
                'label' => 'Complément d\'adresse'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
