<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Utilisateurs;

class UtilisateurFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
		/*
    	$utilisateurs = array(
    		'user1' => ['login1','username1','mdp1'],
    		'user2' => ['login2','username2','mdp2'],
    		'user3' => ['login3','username3','mdp3'],
    		'user4' => ['login4','username4','mdp4']
    	);

		foreach ($utilisateurs as $utilisateur => $value) {
			$user = new Utilisateurs();
			$user->setLogin($value[0]);
			$user->setNom($value[1]);
			$user->setMdp($value[2]);

			$manager->persist($user);
		}

		$manager->flush();
		*/
	}
}
