<?php

namespace App\Form;

use App\Entity\Entrant;
use App\Entity\Event;
use App\Entity\Modules\ModuleTeamInformation;
use App\Entity\Modules\ModuleTeamParameters;
use App\Repository\EntrantRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModuleTeamInformationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('teamName', TextType::class, [
                'label' => 'Team name:',
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'The dream team'
                ],
            ])
            ->add('teamColor', TextType::class, [
                'label' => 'Team Color:',
                'required' => false,
                'attr' => [
                    'class' => 'form-control mb-2',
                ],
            ])
            // Permit to display entrants field before save button
            ->add('entrants')
//            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $formEvent) {
//                $moduleTeamParameters = $formEvent;
//                $moduleTeam = $moduleTeamParameters->getModuleTeam();
//                $event = $moduleTeam->getEvent();
//
//                $formEvent->getForm()->add('entrants', EntityType::class, [
//                    'choice_label' => 'pseudo',
//                    'multiple' => true,
//                    'class' => Entrant::class,
//                    'label' => 'Entrants:',
//                    'required' => true,
//                    'by_reference' => false,
//                    'expanded' => false,
//                    'attr' => [
//                        'class' => 'form-control mt-1 mb-1',
//                    ],
//                    'query_builder' => function (EntrantRepository $entrantRepository) use ($event) {
//                        return $entrantRepository->findAllEntrantsByEvent($event);
//                    },
//                ]);
//            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ModuleTeamInformation::class,
        ]);
    }
}