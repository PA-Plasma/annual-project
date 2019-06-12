<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create();
        // Create admin user
        $adminUser = (new User())
        ->setPseudo('Admin')
        ->setEmail('admin@plasma.fr')
        ->setRoles(["ROLE_USER","ROLE_ADMIN"])
        ->setPassword('$argon2i$v=19$m=1024,t=2,p=2$VnJjeng4N0g0NHlia1FPNQ$JqrG4tD1r6FwsenhYH5zXwBzFn9ogNdf5vZJx35DrJU');
        $manager->persist($adminUser);

        // Create main user
        $casualUser = (new User())
            ->setPseudo('User')
            ->setEmail('user@plasma.fr')
            ->setRoles(["ROLE_USER"])
            ->setPassword('$argon2i$v=19$m=1024,t=2,p=2$YUR6NXVZUWkxTGFoVUZCVQ$JQWu1QXTSYJnwHiq09fbwmwZglHIrqTqvRKqPiac+pw');
        $manager->persist($casualUser);

        // Create casual users
        for ($i=0; $i < 20; $i++){
            $userName = $faker->userName;
            $user = (new User())
                ->setPseudo($userName)
                ->setEmail($userName.'@plasma.fr')
                ->setRoles(["ROLE_USER"])
                ->setPassword('$argon2i$v=19$m=1024,t=2,p=2$YUR6NXVZUWkxTGFoVUZCVQ$JQWu1QXTSYJnwHiq09fbwmwZglHIrqTqvRKqPiac+pw');
            $manager->persist($user);
        }

        $manager->flush();
    }
}
