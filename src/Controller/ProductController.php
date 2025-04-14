<?php

namespace App\Controller;

use App\Service\ApiUrlBuilder;
use App\Service\AuthorizedHttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Throwable;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ApiUrlBuilder $apiUrlBuilder,
    ) {
    }

    #[Route('/products', name: 'app_products')]
    public function index(AuthorizedHttpClient $client): Response
    {
        try {
            $response = $client->request('GET', $this->apiUrlBuilder->build('products'));
            $data = $response->toArray();
        } catch (\Exception $e) {
            $this->addFlash('error', 'Failed to fetch products: ' . $e->getMessage());
            $data = ['products' => []];
        }

        return $this->render('product/index.html.twig', [
            'products' => $data['products'] ?? [],
        ]);
    }

    #[Route('/product', name: 'app_show_product')]
    public function showOne(Request $request, AuthorizedHttpClient $client): Response
    {
        $productId = $request->query->get('id');
        try {
            $response = $client->request('GET', $this->apiUrlBuilder->build("product/$productId"));

            if ($response->getStatusCode() !== 200) {
                return $this->render('product/not_found.html.twig');
            }

            $data = $response->toArray();
            if (empty($data['product'])) {
                return $this->render('product/not_found.html.twig');
            }

            return $this->render('product/show_product.html.twig', [
                'product' => $data['product'],
            ]);
        }  catch (Throwable $e) {
            return $this->render('product/not_found.html.twig');
        }
    }

}
