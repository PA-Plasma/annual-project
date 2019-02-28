<?php

namespace App\Form;

use App\Entity\Entrant;
use App\Entity\Event;
use App\Entity\Modules\ModuleTeamParameters;
use App\Repository\EntrantRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleTeamParametersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nb_entrants')
            ->add('Save', SubmitType::class, [
                'attr' => ['class' => 'btn btn-md btn-primary mt-1 save'],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModuleTeamParameters::class,
        ]);
    }
}