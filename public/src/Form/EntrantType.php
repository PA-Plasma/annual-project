<?php

namespace App\Form;

use App\Entity\Entrant;
use App\Entity\Event;
use App\Entity\User;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'pseudo_input form-control mt-1 mb-1',
                    'placeholder' => 'Pseudo',
                    'list' => 'pseudo',
                ],
            ])
            ->add('user_related', EntityType::class, [
                'choice_label' => 'email',
                'class' => User::class,
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'id_user_related form-control mt-1 mb-1 hide',
                    'placeholder' => 'Email'
                ],
            ])
            ->add('email', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control mt-1 mb-1',
                    'placeholder' => 'Email',
                    'style' => 'display:none'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Entrant::class,
        ]);
    }
}
