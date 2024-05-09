<?php

namespace App\DataFixtures;

use App\Entity\TLogin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = (new TLogin())->setUsername("adminitTest");

        $user->setPassword($this->passwordEncoder->hashPassword($user,"adminitTest"));
     
        $manager->persist($user);
        $manager->flush();
    }
}
