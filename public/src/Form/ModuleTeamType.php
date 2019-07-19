<?php

namespace App\Form;

use App\Entity\Entrant;
use App\Entity\Event;
use App\Entity\Modules\ModuleTeam;
use App\Entity\Modules\ModuleTeamInformation;
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

class ModuleTeamType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teams', CollectionType::class, [
                    'label' => 'Équipes',
                    'entry_type' => ModuleTeamInformationType::class,
                    'entry_options' => [
                        'label' => false,
                        'event' => $options['event']
                    ],
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModuleTeam::class,
            'event' => null
        ]);
    }
}