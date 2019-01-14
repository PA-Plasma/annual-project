<?php

namespace App\Form;

use App\Entity\User;
use App\Service\RolesHelper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
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
            'nickname',
            TextType::class,
            [
                'label' => 'Choose a cute nickname: '
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
            PasswordType::class,
            [
                'label' => 'Choise a strong password',
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