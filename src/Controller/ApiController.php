<?php

namespace App\Controller;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
     /**
     * @Route("/consume/api/data", name="consume_api_data")
     */
    public function consumeApiData(): JsonResponse
    {
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', 'http://localhost:8000/api/budget/total-montant');
        $data = $response->toArray();

        return $this->json($data);
    }
}
