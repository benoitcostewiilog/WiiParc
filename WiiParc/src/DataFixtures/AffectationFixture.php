<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Affectations;
use App\Entity\Parc;
use App\Entity\Societe;
use App\Entity\TypeVehicule;
use App\Entity\Propriete;


class AffectationFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // TYPE VEHICULE
        $vehicule_obj = array();
    	$vehicules = array(
    		'Chariot',
    		'Poids lourd',
    		'Vehicule de fonction',
    	);

    	foreach ($vehicules as $vehicule) {
    		$veh = new TypeVehicule();
            $veh->setNom($vehicule);
            array_push($vehicule_obj, $veh);

    		$manager->persist($veh);
        }
        
        $manager->flush();

        // PROPRIETE
        $propriete_obj = array();
    	$proprietes = array(
    		'Location',
    		'Acheté',
    		'Appartient au client',
    	);

    	foreach ($proprietes as $propriete) {
    		$pro = new Propriete();
            $pro->setNom($propriete);
            array_push($propriete_obj, $pro);

    		$manager->persist($pro);
    	}

        $manager->flush();

        // PARC
        $parcs_obj = array();
        $parcs = array(
    		'parc1' => [1,'marque1','nserie1',1,'immatriculation1',2001,'commentaires1'],
    		'parc2' => [2,'marque2','nserie2',2,'immatriculation2',2002,'commentaires2'],
    		'parc3' => [0,'marque3','nserie3',2,'immatriculation3',2003,'commentaires3'],
    		'parc4' => [2,'marque4','nserie4',0,'immatriculation4',2004,'commentaires4'],
    	);

    	foreach ($parcs as $p => $value) {
            $parc = new Parc();
    		$parc->setType($vehicule_obj[$value[0]]);
    		$parc->setMarque($value[1]);
    		$parc->setNserie($value[2]);
    		$parc->setPropriete($propriete_obj[$value[3]]);
    		$parc->setImmatriculation($value[4]);
    		$parc->setAnnee($value[5]);
    		$parc->setCommentaires($value[6]);
            array_push($parcs_obj, $parc);

    		$manager->persist($parc);
    	}

        $manager->flush();

        // SOCIETE
        $societes_obj = array();
    	$societes = array(
    		'societe1',
    		'societe2',
    		'societe3',
    		'societe4',
    	);

    	foreach ($societes as $societe) {
    		$soc = new Societe();
            $soc->setNom($societe);
            array_push($societes_obj, $soc);

    		$manager->persist($soc);
    	}

        $manager->flush();

        // AFFECTATION

        $affectations = array(
            'affectation1' => [0, 0, new \DateTime('2018-07-03'), new \DateTime('2018-07-05'), '39'],
            'affectation2' => [1, 1, new \DateTime('2018-07-03'), new \DateTime('2018-07-05'), '40'],
            'affectation3' => [2, 2, new \DateTime('2018-07-03'), new \DateTime('2018-07-05'), '41'],
            'affectation4' => [3, 3, new \DateTime('2018-07-03'), new \DateTime('2018-07-05'), '42'],
        );

        foreach ($affectations as $a => $value) {
            $affectation = new Affectations();
            $affectation->setParc($parcs_obj[$value[0]]);
            $affectation->setSociete($societes_obj[$value[1]]);
            $affectation->setDentree($value[2]);
            $affectation->setDsortie($value[3]);
            $affectation->setNparc($value[4]);

            $manager->persist($affectation);
        }

        $manager->flush();
    }
}
