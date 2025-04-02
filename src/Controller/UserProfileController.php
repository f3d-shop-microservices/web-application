<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_user_profile')]
    public function index(): Response
    {
        return $this->render('user_profile/index.html.twig', [
            'controller_name' => 'UserProfileController',
        ]);
    }

    #[Route('/logout', name: 'app_user_logout')]
    public function logout(): Response
    {
        return new Response('Logout success');
    }

    #[Route('/loginForm', name: 'app_user_login')]
    public function login(Request $request): Response {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
        }

        return $this->render('user_profile/login.html.twig', [
            'form' => $form
        ]);
    }

}
