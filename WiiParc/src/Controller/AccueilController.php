<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Parc;
use Doctrine\ORM\EntityManagerInterface;

class AccueilController extends Controller
{
    /**
     * @Route("/accueil", name="accueil")
     */
    public function index(EntityManagerInterface $em)
    {    	
    	$parcs = $em->getRepository(Parc::class)->findAll();

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'parcs' => $parcs,
        ]);
    }
}
