<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class ChangePasswordController extends Controller
{
    /**
     * @Route("/change_password", name="change_password")
     */
    public function change_password(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder, TokenStorageInterface $tokenStorage)
    {
    	$session = $request->getSession();
    	$user = $tokenStorage->getToken()->getUser();
    	$form = $this->createFormBuilder()
    		->add("password", PasswordType::class)
    		->add("plainPassword", RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options'  => array('label' => 'New Password'),
                    'second_options' => array('label' => 'Repeat New Password')
            ))
            ->add("modifier", SubmitType::class)
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            if($passwordEncoder->isPasswordValid($user, $data["password"]))
            {
                $new_password = $passwordEncoder->encodePassword($user, $data["plainPassword"]);
                $user->setPassword($new_password);
                $em->persist($user);
                $em->flush();
				$session->getFlashBag()->add('info', 'Password changed');
				return $this->redirectToRoute('accueil');
			}
		}

        return $this->render('change_password/change_password.html.twig', [
            'controller_name' => 'ChangePasswordController',
            'form' => $form->createView(),
        ]);
    }
}
