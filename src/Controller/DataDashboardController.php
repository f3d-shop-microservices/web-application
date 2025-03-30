<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DataDashboardController extends AbstractController
{
    #[Route('/data', name: 'app_data_dashboard')]
    public function index(): Response
    {
        return $this->render('data_dashboard/index.html.twig', [
            'controller_name' => 'DataDashboardControllerr',
        ]);
    }

    #[Route('/tableData', name: 'app_table_data')]
    public function tableData(Request $request): Response
    {
        $table = $request->query->get('table');

        return $this->render('data_dashboard/index.html.twig', [
            'controller_name' => 'DataDashboardController',
        ]);
    }

    #[Route('/deleteTestData', name: 'app_delete_data')]
    public function deleteData(Request $request): Response
    {
        $table = $request->query->get('table');

        return $this->render('data_dashboard/index.html.twig', [
            'controller_name' => 'DataDashboardController',
        ]);
    }

    #[Route('/createTestData', name: 'app_create_data', methods: ['POST'])]
    public function createData(Request $request): Response
    {
        $table = $request->query->get('table');

        return $this->render('data_dashboard/index.html.twig', [
            'controller_name' => 'DataDashboardController',
        ]);
    }
}
