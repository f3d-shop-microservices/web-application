<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MonitoringController extends AbstractController
{
    #[Route('/monitor', name: 'app_monitoring')]
    public function index(): Response
    {
        return $this->render('monitoring/index.html.twig', [
            'controller_name' => 'MonitoringController',
        ]);
    }

    #[Route('/systemStatus', name: 'app_system_status')]
    public function systemStatus(Request $request): Response
    {
        $layer = $request->query->get('layer');

        return $this->render('monitoring/index.html.twig', [
            'controller_name' => 'MonitoringController',
        ]);
    }

    #[Route('/registry', name: 'app_registry')]
    public function registry(): Response
    {
        return $this->render('monitoring/index.html.twig', [
            'controller_name' => 'MonitoringController',
        ]);
    }
}
