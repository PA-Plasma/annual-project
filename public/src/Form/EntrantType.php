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
                    'list' => 'pseudo'
                ],
            ])
            ->add('show_user_related', CheckboxType::class, [
                'label' => 'Externe ?',
                'required' => false,
                'attr' => [
                    'class' => 'checkbox_input'
                ],
            ])
            ->add('user_related', EntityType::class, [
                'choice_label' => 'email',
                'class' => User::class,
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'id_user_related form-control mt-1 mb-1 hide',
                    'placeholder' => 'Email'
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
