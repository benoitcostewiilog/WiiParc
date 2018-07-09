<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\ParcCreationFormType;
use App\Form\AffectationsCreationFormType;
use App\Entity\Parc;
use App\Entity\Affectations;
use \Datetime;
use Symfony\Component\HttpFoundation\JsonResponse;

class ParcController extends Controller
{
	/**
	 * @Route("/parc/vue/{id}", name="parc_vue")
	 */
	public function vue($id, EntityManagerInterface $em, Request $request)
	{
		$affectation = $em->getRepository(Affectations::class)->findOneByNparc($id);
		$form = $this->createForm(AffectationsCreationFormType::class, $affectation);

		return $this->render('parc/vue/index.html.twig', [
			'controller_name' => 'ParcController',
			'id' => $id,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/parc/creation", name="parc_creation")
	 */
	public function creation(EntityManagerInterface $em, Request $request)
	{
		$affectation = new Affectations();
		$form = $this->createForm(AffectationsCreationFormType::class, $affectation);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if ($form->get('validation')->isClicked()) {
				$affectation = $form->getData();

				$em->persist($affectation);
				$em->flush();    
			}

			return $this->redirectToRoute('accueil', array('page' => 1));
		}

		// AJAX
		if ($request->isXmlHttpRequest()) {
			$affectations = $em->getRepository(Affectations::class)->findAll();
			$bool = false;
			$search = $request->request->get('search');
			foreach($affectations as $a) {
				if (strcmp($search, $a->getNparc()) == 0) {$bool = true;}
			}
			return new JsonResponse($bool);
		}

		return $this->render('parc/creation/index.html.twig', [
			'controller_name' => 'ParcController',
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/parc/modification/{id}", name="parc_modification")
	 */
	public function modification($id, EntityManagerInterface $em, Request $request)
	{
		$affectation = $em->getRepository(Affectations::class)->findOneByNparc($id);
		$parc = $affectation->getParc();
		$form = $this->createForm(ParcCreationFormType::class, $parc);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if ($form->get('validation')->isClicked()) {
				$parc = $form->getData();

				$em->flush();
			}

			return $this->redirectToRoute('accueil', array('page' => 1));
		}

		return $this->render('parc/modification/index.html.twig', [
			'controller_name' => 'ParcController',
			'id' => $id,
			'form' => $form->createView(),
		]);
	}

	/**
	 * @Route("/parc/changement_numero/{id}", name="parc_changement_numero")
	 */

	 public function changement_numero($id, EntityManagerInterface $em, Request $request)
	 {
		$affectation = $em->getRepository(Affectations::class)->findOneByNparc($id);
		$new_affectation = new Affectations();

		$parc = $affectation->getParc();
		$new_parc = new Parc();

		$new_parc->setType($parc->getType());
		$new_parc->setMarque($parc->getMarque());
		$new_parc->setNserie($parc->getNserie());
		$new_parc->setPropriete($parc->getPropriete());
		$new_parc->setImmatriculation($parc->getImmatriculation());
		$new_parc->setAnnee($parc->getAnnee());
		$new_parc->setCommentaires($parc->getCommentaires());

		$affectations = $em->getRepository(Affectations::class)->findParcAffectations($affectation->getNparc());
		foreach($affectations as $a) {
			$new_parc->addAffectation($a);
		}
		$new_affectation->setParc($new_parc);
		$form = $this->createForm(AffectationsCreationFormType::class, $new_affectation);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			if ($form->get('validation')->isClicked()) {
				$new_affectation = $form->getData();
				$affectation->setDsortie(new Datetime(date("d/m/y")));
				$em->persist($new_affectation);
				$em->flush();
			}

			return $this->redirectToRoute('accueil', array('page' => 1));
		}

		// AJAX
		if ($request->isXmlHttpRequest()) {
			$bool = false;
			$search = $request->request->get('search');
			foreach($affectations as $a) {
				if (strcmp($search, $a->getNparc()) == 0) {$bool = true;}
			}
			return new JsonResponse($bool);
		}

		return $this->render('parc/changement_numero/index.html.twig', [
			'controller_name' => 'ParcController',
			'id' => $id,
			'form' => $form->createView(),
		]);
	 }
}