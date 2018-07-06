<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Affectations;
use Doctrine\ORM\EntityManagerInterface;

class AccueilController extends Controller
{
	/**
	 * @Route("/accueil", name="accueil")
	 */
	public function index(EntityManagerInterface $em)
	{
		$affectations = $em->getRepository(Affectations::class)->findAll();

		return $this->render('accueil/index.html.twig', [
			'controller_name' => 'AccueilController',
			'affectations' => $affectations,
		]);
	}
}
