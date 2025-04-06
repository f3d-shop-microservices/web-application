<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class MonitoringController extends AbstractController
{
    #[Route('/monitor', name: 'app_monitoring')]
    public function index(): Response
    {
        return $this->render('monitoring/index.html.twig', [
            'data' => [],
        ]);
    }

    #[Route('/systemStatus', name: 'app_system_status')]
    public function systemStatus(Request $request, HealthController $healthController, HttpClientInterface $client): Response
    {
        $layer = $request->query->get('layer');
        switch ($layer) {
            case 'web':
                $healthResponse = $healthController->health();
                $collection = json_decode($healthResponse->getContent(), true);
                break;
            case 'services':
                $collection = [];
                $response = $client->request('GET', $_ENV['GATEWAY_SVC_HOST'] . '/health');
                $collection[] = $response->toArray();

                $response = $client->request('GET', $_ENV['GATEWAY_SVC_HOST'] . '/api/auth/health');
                $collection[] = $response->toArray();

                $response = $client->request('GET', $_ENV['GATEWAY_SVC_HOST'] . '/api/product/health');
                $collection[] = $response->toArray();
                break;
            case 'databases':
                $collection = [];
                break;
        }
        return $this->render('monitoring/index.html.twig', [
            'data' => $collection,
        ]);
    }

    #[Route('/registry', name: 'app_registry')]
    public function registry(): Response
    {
        return $this->render('monitoring/index.html.twig', [
            'data' => [],
        ]);
    }
}
