<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateurs;
use App\Entity\Droits;
use App\Form\UtilisateursFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


class UtilisateursGestionController extends Controller
{
    /**
     * @Route("/utilisateurs/gestion", name="utilisateurs_gestion")
     */
    public function index(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        
        $user = new Utilisateurs();
        
        // creation
        $form_creation = $this->createForm(UtilisateursFormType::class, $user);

        $form_creation->handleRequest($request);

        if ($form_creation->isSubmitted() && $form_creation->isValid()) {
            $user = $form_creation->getData();

            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            
            $em->persist($user);
            $em->flush();
            
            return $this->redirectToRoute('utilisateurs_gestion');
        }

        // modification
        $form_modif = $this->createFormBuilder()
            ->add('id_user', HiddenType::class, array(
                'mapped' => false,
            ))
            ->add('email', EmailType::class)
            ->add('username', TextType::class)
            ->add('droits', EntityType::class, array(
                'class' => 'App\Entity\Societe',
                'choice_label' => 'nom',
                'multiple' => true,
                'required' => false,
            ))
            ->add('roles', EntityType::class, array(
                'class' => 'App\Entity\Roles',
                'choice_label' => 'nom',
                'multiple' => false,
                'required' => false,
            ))
        ->getForm();

        $form_modif->handleRequest($request);

        if ($form_modif->isSubmitted() && $form_modif->isValid()) {
            
            $id = $form_modif->get("id_user")->getData();
            $user = $em->getRepository(Utilisateurs::class)->find($id);

            $user_modif = $form_modif->getData();

            $user->setUsername($user_modif['username']);
            $user->setEmail($user_modif['email']);
            
            if(!empty($user_modif['droits'])) {
                foreach ($user_modif['droits'] as $societe) {
                    #$droit = new Droits();
                    #$droit->setSociete($societe);

                    #$em->persist($droit);
                    $societe->addUtilisateur($user);
                }
            }
            if(!empty($user_modif['roles'])) {
                foreach($user_modif['roles'] as $role) {
                    $user->setRoles($role->getNom());
                }
            }

            $em->persist($user);
            $em->flush();
            $session = $request->getSession();
            $session->getFlashBag()->add('info', 'User changed');
        
            return $this->redirectToRoute('utilisateurs_gestion');
        }

        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        if ($request->isXMLHttpRequest()) {

            $id = $request->get('id');
            $user =  $em->getRepository(Utilisateurs::class)->find($id);
            $jsonContent = $serializer->serialize($user, 'json');
            return new JsonResponse($jsonContent);
        }


        $utilisateurs = $em->getRepository(Utilisateurs::class)->findAll();

        return $this->render('utilisateurs_gestion/index.html.twig', [
            'controller_name' => 'UtilisateursGestionController',
            'utilisateurs' => $utilisateurs,
            'form_creation' => $form_creation->createView(),
            'form_modif' => $form_modif->createView(),
        ]);
    }
}
