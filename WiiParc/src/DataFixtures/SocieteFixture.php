<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Societe;

class SocieteFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
    	$societes = array(
    		'societe1',
    		'societe2',
    		'societe3',
    		'societe4',
    	);

    	foreach ($societes as $societe) {
    		$soc = new Societe();
    		$soc->setNom($societe);

    		$manager->persist($soc);
    	}

        $manager->flush();
    }
}
