<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Parc;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ParcCreationFormType;
use Symfony\Component\HttpFoundation\Request;


class ParcController extends Controller
{
    /**
     * @Route("/parc/vue/{id}", name="parc_vue")
     */
    public function vue($id, EntityManagerInterface $em, Request $request)
    {
        $parc = $em->getRepository(Parc::class)->find($id);
        $form = $this->createForm(ParcCreationFormType::class, $parc);

        #$form->handleRequest($request);



        return $this->render('parc/vue/index.html.twig', [
            'controller_name' => 'ParcController',
            #'parc' => $parc,
            'id' => $id,
            'form' => $form->createView(),
        ]);
    }

	/**
     * @Route("/parc/creation", name="parc_creation")
     */
    public function creation(EntityManagerInterface $em, Request $request)
    {

        $parc = new Parc();
        $form = $this->createForm(ParcCreationFormType::class, $parc);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('validation')->isClicked()) {
                $parc = $form->getData();

                $em->persist($parc);
                $em->flush();    
            }

            return $this->redirectToRoute('accueil');
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
        $parc = $em->getRepository(Parc::class)->find($id);
        $form = $this->createForm(ParcCreationFormType::class, $parc);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('validation')->isClicked()) {
                $parc = $form->getData();

                #$em->persist($parc);
                $em->flush();    
            }

            return $this->redirectToRoute('accueil');
        }

        return $this->render('parc/modification/index.html.twig', [
            'controller_name' => 'ParcController',
            #'parc' => $parc,
            'id' => $id,
            'form' => $form->createView(),
        ]);
    }


}
