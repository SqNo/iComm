<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    public function register(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newUser = $form->getData();
            if($em->getRepository(User::class)->findOneBy(["email" => $newUser->getEmail()]))
            {
                $this->addFlash(
                    'notice',
                    'Vous etes déja enregistré, connectez vous !'
                );
               return $this->redirectToRoute("index");
            }
            $newUser->setPassword($encoder->encodePassword($newUser, $newUser->getPassword()));
            $newUser->setRoles(['ROLE_USER']);

            $em->persist($newUser);
            $em->flush();

            $this->addFlash(
                'notice',
                'Votre compte a bien été enregistré !'
            );
           return $this->redirectToRoute("index");
        }

        return $this->render('security/register.html.twig', [
                'form' => $form->createView(),
            ]);
    }
}
