<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
	public function __construct(private readonly UserPasswordHasherInterface $hasher) {
	
	}
	
	public function load(ObjectManager $manager): void
    {
	    $faker = (new \Faker\Factory())::create('fr_FR');
	    $faker->addProvider(new \Faker\Provider\FakeCar($faker));
     
	    for($i = 0, $c = 10; $i < $c; $i++) {
		    $user = new User();
		    $this->setReference('user'.$i, $user);
		    $roles = [];
			if($i % 2) {
				$roles = ["ROLE_PROPRIETAIRE","ROLE_USER"];
			} else {
				$roles = ["ROLE_LOCATAIRE","ROLE_USER"];
			}
			if($i % 4) {
				$roles[] = "ROLE_ADMIN";
			}
			$name = $faker->name();
		    $user->setRoles($roles)
			    ->setFirstName(explode(' ', $name)[0])
			    ->setLastName(explode(' ', $name)[1])
			    ->setEmail(explode(' ', $name)[0].$i."@gmail.com")
			    ->setPassword($this->hasher->hashPassword($user, 'admin'));
		    $manager->persist($user);
	    }
        $manager->flush();
    }
}
