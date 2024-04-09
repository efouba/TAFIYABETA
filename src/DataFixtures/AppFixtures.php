<?php

namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
     $this->userPasswordHasher=$userPasswordHasher;   
    }
    public function load(ObjectManager $manager): void
    {
     //Creation d'un user 
     $user=new User();
     $user->setUsername("user1");
     $user->setRoles(["ROLE_USER"]);
     $user->setPassword($this->userPasswordHasher->hashPassword($user,"password"));
     $manager->persist($user);

     //Creation du conpte administrateur
     $useradmin=new User();
     $useradmin->setUsername("admin");
     $useradmin->setRoles(["ROLE_ADMIN"]);
     $useradmin->setPassword($this->userPasswordHasher->hashPassword($useradmin,"password"));
     $manager->persist($useradmin);
     $manager->flush();
    }
}