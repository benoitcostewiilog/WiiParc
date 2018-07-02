<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateurs;

class UtilisateursGestionController extends Controller
{
    /**
     * @Route("/utilisateurs/gestion", name="utilisateurs_gestion")
     */
    public function index(EntityManagerInterface $em)
    {
    	$utilisateurs = $em->getRepository(Utilisateurs::class)->findAll();

        return $this->render('utilisateurs_gestion/index.html.twig', [
            'controller_name' => 'UtilisateursGestionController',
            'utilisateurs' => $utilisateurs,
        ]);
    }
}
