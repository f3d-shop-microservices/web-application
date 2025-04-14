<?php

namespace App\Controller;

use App\Service\ApiUrlBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UserProfileController extends AbstractController
{

    public function __construct(
        private readonly ApiUrlBuilder $apiUrlBuilder,
    ) {
    }

    #[Route('/profile', name: 'app_user_profile')]
    public function index(): Response
    {
        return $this->render('user_profile/index.html.twig', [
            'controller_name' => 'UserProfileController',
        ]);
    }

    #[Route('/logout', name: 'app_user_logout')]
    public function logout(SessionInterface $session, Request $request): Response
    {
        $session->remove('jwt_token');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/loginForm', name: 'app_user_login')]
    public function login(
        Request $request,
        SessionInterface $session,
        HttpClientInterface $httpClient
    ): Response {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class)
            ->getForm();

        $form->handleRequest($request);

        $error = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            try {
                $response = $httpClient->request('POST', $this->apiUrlBuilder->build('login'), [
                    'json' => [
                        'email' => $data['email'],
                        'password' => $data['password'],
                    ],
                    'verify_peer' => false,
                    'verify_host' => false,
                ]);

                if ($response->getStatusCode() === 200) {
                    $token = $response->toArray()['token'];
                    $session->set('jwt_token', $token);

                    return $this->redirectToRoute('app_home');
                } else {
                    $error = 'Неверные данные для входа';
                }
            } catch (\Exception $e) {
                $error = 'Ошибка при попытке входа: ' . $e->getMessage();
            }
        }

        return $this->render('user_profile/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }

}
