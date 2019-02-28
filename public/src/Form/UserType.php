<?php

namespace App\Form;

use App\Entity\User;
use App\Service\RolesHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

/**
 * Class UserType
 *
 * @category  Class
 * @package   App\Form
 */
class UserType extends AbstractType
{
    /**
     * @var array $rolesRanking
     */
    private $rolesRanking;

    /**
     * UserType constructor
     *
     * @param RolesHelper $rolesHelper
     */
    public function __construct(RolesHelper $rolesHelper)
    {
        $this->rolesRanking = $rolesHelper->getRoles();;
    }

    /**
     * Build user form
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'pseudo',
            TextType::class,
            [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control mt-1 mb-1',
                    'placeholder' => 'Pseudo'
                ],
            ]
        )
        ->add(
            'email',
            EmailType::class,
            [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control mt-1 mb-1',
                    'placeholder' => 'Email'
                ],
            ]
        );

        if ($options['back'] === true) {
            $builder->add(
                'roles',
                ChoiceType::class,
                [
                    'label'    => false,
                    'multiple' => true,
                    'choices'  => $this->rolesRanking,
                    'required' => false,
                    'attr' => [
                        'class' => 'form-control mb-2',
                    ],
                ]);
        }

        $builder->add(
            'password',
            RepeatedType::class,
            [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-1',
                        'placeholder' => 'Password'
                    ],
                ],
                'second_options' => [
                    'label' => false,
                    'required' => true,
                    'attr' => [
                        'class' => 'form-control mb-2',
                        'placeholder' => 'Confirm password'
                    ],
                ],
            ]
        );
        if ($options['profile'] === true) {
            $builder->add(
                'imageFile',
                VichImageType::class
            );
        }
        if ($options['profile'] === false) {
            $builder->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Register',
                    'attr'  => [
                        'class' => 'btn btn-md btn-primary mt-1',
                    ],
                ]
            );
        }

    }

    /**
     * Configure options
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'back' => false,
            'profile' => false,
        ]);
    }
}
