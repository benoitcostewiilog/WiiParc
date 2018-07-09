<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Affectations;
use Doctrine\ORM\EntityManagerInterface;

class AccueilController extends Controller
{
	/**
	 * @Route("/accueil/{page}", name="accueil")
	 */
	public function index($page = 1, EntityManagerInterface $em, Request $request)
	{
		$nbPerPage = 3;

		if ($page < 1) { throw $this->createNotFoundException("La page ".$page." n'existe pas."); }

		/* AJAX
		if ($request->isXmlHttpRequest()) {
			$page = $request->request->get('page');
			$nbPerPage = $request->request->get('nbPerPage');
			return new JsonResponse($page);
		}
		*/

		$listAffectations = $em->getRepository(Affectations::class)->findXtoY($page, $nbPerPage);

		$nbPages = ceil(count($listAffectations) / $nbPerPage);
		if ($page > $nbPages) { throw $this->createNotFoundException("La page ".$page." n'existe pas."); }

		return $this->render('accueil/index.html.twig', array(
			'listAffectations' => $listAffectations,
			'nbPages' => $nbPages,
			'page' => $page,
		));
	}
}
