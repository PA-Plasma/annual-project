<?php

namespace App\Command;

use App\Entity\User;
use App\Service\RolesHelper;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    private $objectManager;
    private $roles;
    private $passwordEncorder;

    const EMAIL_VALIDATION_REGEX = '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

    public function __construct(ObjectManager $objectManager, RolesHelper $rolesHelper, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct();
        $this->objectManager = $objectManager;
        $this->roles = array_values($rolesHelper->getRoles());
        $this->passwordEncorder = $passwordEncoder;
    }

    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Create new user.')
            ->setHelp('This command allow you to create new user.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Create user : ');
        // All questions with validations
        $pseudo   = $io->ask('What is the user pseudo?', 'JohnDoe');
        $email    = $io->ask(
            'What is the user email?',
            'john@doe.fr',
            function ($email) {
                if (!preg_match(self::EMAIL_VALIDATION_REGEX, $email)) {
                    throw new \RuntimeException('Please insert a valid email address.');
                }

                return $email;
            }
        );
        $password = $io->askHidden(
            'What is your password?',
            function ($password) {
                if (empty($password)) {
                    throw new \RuntimeException('Password cannot be empty.');
                }

                return $password;
            }
        );
        $io->section('Select roles :');
        $firstRole = $io->choice('Select user role or create one in addition to "ROLE_USER"', $this->roles);
        // Roles questions
        $anotherRole = $io->confirm('Do you want to add another role?', false);
        $secondRole  = null;
        if ($anotherRole) {
            $secondRole = $io->ask('Add another role in addition to "ROLE_USER" and "' . $firstRole . '" ');
        }
        $userRoles = 'ROLE_USER,' . $firstRole;

        if ($secondRole) {
            $userRoles = $userRoles . ',' . $secondRole;
        }
        // Confirm question
        $io->section('Confirm creation :');
        $io->text(
            [
                'Pseudo: ' . $pseudo,
                'Email: ' . $email,
                'Roles: ' . $userRoles,
            ]
        );
        $validate = $io->confirm('Are you sure to create the user above?', 'yes');

        // Check data
        if (!$pseudo || !$email || !$password || !$userRoles) {
            $io->error(
                [
                    'There is data missing sorry.',
                ]
            );
            return;
        } elseif (!$validate) {
            $io->error(
                [
                    'You answer "no", try again if you want.',
                ]
            );
            return;
        }
        if ($this->objectManager->getRepository(User::class)->findOneBy(["email" => $email])) {
            $io->error(
                [
                    'User allready use this email',
                ]
            );
            return;
        }

        $userRoles = explode(",", $userRoles);

        // Save user data
        $user = new User();
        $user->setPseudo($pseudo);
        $user->setEmail($email);
        // set encode password
        $password = $this->passwordEncorder->encodePassword($user, $password);
        $user->setPassword($password);
        $user->setRoles($userRoles);

        $this->objectManager->persist($user);
        $this->objectManager->flush();

        $io->success(
            [
                'The user ' . $pseudo . ' was successfully created',
            ]
        );
    }
}