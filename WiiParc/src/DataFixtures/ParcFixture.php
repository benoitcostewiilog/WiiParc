<?php

namespace App\DataFixtures;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Parc;


class ParcFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
    	$parcs = array(
    		'parc1' => ["type1",'marque1','nserie1','propriete1','immatriculation1',2001,'commentaires1'],
    		'parc2' => ['type2','marque2','nserie2','propriete2','immatriculation2',2002,'commentaires2'],
    		'parc3' => ['type3','marque3','nserie3','propriete3','immatriculation3',2003,'commentaires3'],
    		'parc4' => ['type4','marque4','nserie4','propriete4','immatriculation4',2004,'commentaires4'],
    	);

    	foreach ($parcs as $p => $value) {
    		$parc = new Parc();
    		$parc->setType($value[0]);
    		$parc->setMarque($value[1]);
    		$parc->setNserie($value[2]);
    		$parc->setPropriete($value[3]);
    		$parc->setImmatriculation($value[4]);
    		$parc->setAnnee($value[5]);
    		$parc->setCommentaires($value[6]);

    		$manager->persist($parc);
    	}

        $manager->flush();
    }
}
