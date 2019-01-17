<?php

namespace App\Form;

use App\Entity\Entrant;
use App\Entity\Event;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pseudo', TextType::class, [
                'attr' => ['class' => 'pseudo_input'],
                'label' => 'Pseudo'
            ])
            ->add('user_related', EntityType::class, [
                'choice_label' => 'email',
                'class' => User::class,
                'attr' => ['class' => 'id_user_related']
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
