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
        $roles              = $rolesHelper->getRoles();
        $this->rolesRanking = $roles;
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
                'label' => 'Choose a cute pseudo: '
            ]
        )
        ->add(
            'email',
            EmailType::class,
            [
                'label' => 'User email: ',
            ]
        )->add(
            'roles',
            ChoiceType::class,
            [
                'label'    => 'User roles: ',
                'multiple' => true,
                'choices'  => $this->rolesRanking,
            ]
        )->add(
            'password',
            RepeatedType::class,
            [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Password'
                ],
                'second_options' => [
                    'label' => 'Confirm password'
                ],
            ]
        )->add(
            'submit',
            SubmitType::class,
            [
                'label' => 'Send',
                'attr'  => [
                    'class' => 'btn-primary btn-block',
                ],
            ]
        );
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
        ]);
    }
}
