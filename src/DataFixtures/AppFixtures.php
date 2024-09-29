<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;
use App\Entity\MicroPost;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }
    public function load(ObjectManager $manager): void
    {
        $user2 = new User();
        $user2 -> setEmail('john@test.com');
        $user2 -> setPassword(
            $this -> userPasswordHasher -> hashPassword(
            $user2,
            '12345678'
            )
        );
        $manager -> persist($user2);


        $microPost1 = new MicroPost();
        $microPost1->setTitle("Welcome to İstanbul!");
        $microPost1->setCreated(new DateTime());
        $manager->persist($microPost1);

        $microPost2 = new MicroPost();
        $microPost2->setTitle("Welcome to Çorum!");
        $microPost2->setCreated(new DateTime());
        $manager->persist($microPost2);

        $microPost3 = new MicroPost();
        $microPost3->setTitle("Welcome to Tarlabaşı!");
        $microPost3->setCreated(created: new DateTime());
        $manager->persist($microPost3);
        
        $manager->flush();



        
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
