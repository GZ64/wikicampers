<?php

namespace App\DataFixtures;

use App\Entity\Advert;
use App\Entity\Equipment;
use App\Entity\Thumbnail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Filesystem\Path;

class AdvertFixtures extends Fixture implements DependentFixtureInterface
{
	public function load(ObjectManager $manager): void
	{
		$faker = (new \Faker\Factory())::create('fr_FR');
		$faker->addProvider(new \Faker\Provider\FakeCar($faker));
		
		for ($i = 0, $c = 500; $i < $c; $i++) {
			$idUser = $faker->numberBetween(0, 9);
			if (in_array('ROLE_PROPRIETAIRE', $this->getReference('user' . $idUser)->getRoles())) {
				$advert = new Advert();
				$equipmentNames = $faker->vehicleProperties($faker->numberBetween(2, 5));
				$advert->setIdUser($this->getReference('user' . $idUser)->getID())
					->setTitle($faker->vehicle)
					->setDescription($faker->text())
					->setAvailability(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 week', '+1 week')))
					->setCity($faker->city())
					->setUpdatedAt(new \DateTimeImmutable())
					->setCreatedAt(new \DateTimeImmutable())
					->setPricePerDay($faker->numberBetween(10, 200))
					->setCampingCarSize($faker->numberBetween(2, 50));
				
				foreach ($equipmentNames as $name) {
					// Rechercher un équipement existant avec ce nom
					$existingEquipment = $manager->getRepository(Equipment::class)->findOneBy(['nameEquipment' => $name]);
					if ($existingEquipment) {
						$advert->addEquipment($existingEquipment);
					} else {
						$equipment = new Equipment();
						$equipment->setNameEquipment($name);
						$advert->addEquipment($equipment);
						$manager->persist($equipment);
					}
					// on flush pour pouvoir verifier l'existance de nameEquipment
					$manager->flush();
				}
				
				$manager->persist($advert);
				
				for ($j = 0, $co = $faker->numberBetween(1, 5); $j < $co; $j++) {
					$thumbnail = new Thumbnail();
					$path = $faker->image($dir = Path::makeAbsolute('../../public/img/adverts', __DIR__), $width = 800, $height = 450, 'cars');
					$thumbnail->setPath(pathinfo($path, \PATHINFO_BASENAME))
						->setIdAdvert($advert);
					$manager->persist($thumbnail);
				}
			}
		}
		$manager->flush();
	}
	
	public function getDependencies() {
		return [UserFixtures::class];
	}
}
