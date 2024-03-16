<?php

namespace App\Controller;

use App\Entity\Savings;
use App\Form\SavingsType;
use App\Repository\SavingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @Route("/savings")
 */
class SavingsController extends AbstractController
{
    /**
     * @Route("/", name="app_savings_index", methods={"GET"})
     */
    public function index(SavingsRepository $savingsRepository): Response
    {
        return $this->render('savings/index.html.twig', [
            'savings' => $savingsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_savings_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SavingsRepository $savingsRepository): Response
    {
        $saving = new Savings();
        $form = $this->createForm(SavingsType::class, $saving);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $savingsRepository->add($saving, true);

            return $this->redirectToRoute('app_savings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('savings/new.html.twig', [
            'saving' => $saving,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_savings_show", methods={"GET"})
     */
    public function show(Savings $saving): Response
    {
        return $this->render('savings/show.html.twig', [
            'saving' => $saving,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_savings_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Savings $saving, SavingsRepository $savingsRepository): Response
    {
        $form = $this->createForm(SavingsType::class, $saving);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $savingsRepository->add($saving, true);

            return $this->redirectToRoute('app_savings_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('savings/edit.html.twig', [
            'saving' => $saving,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_savings_delete", methods={"POST"})
     */
    public function delete(Request $request, Savings $saving, SavingsRepository $savingsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$saving->getId(), $request->request->get('_token'))) {
            $savingsRepository->remove($saving, true);
        }

        return $this->redirectToRoute('app_savings_index', [], Response::HTTP_SEE_OTHER);
    }

    

//budget

/**
 * @Route("/consume/api/data", name="consume_api_data")
 */

 public function consumeApiData(Request $request): Response
{

 $httpClient = HttpClient::create();
    $response = $httpClient->request('GET', 'http://127.0.0.1:8002/budget/api/get-data');
    $data = $response->toArray();

    return $this->json($data);
    
}


// expenses
/**
 * @Route("/consume/api/get-total-expenses", name="consume_api_data_total_expenses")
 */

 public function consumeTotalExpenses(Request $request): Response
{

 $httpClient = HttpClient::create();
    $response = $httpClient->request('GET', 'http://127.0.0.1:8000/expenses/api/get-total-expenses');
    $data = $response->toArray();

    return $this->json($data);
    
}


/**
 * @Route("/savings_calculating", name="calculate_savings", methods={"GET"})
 */
public function calculateSavings(Request $request, HttpClientInterface $httpClient): JsonResponse
{
    // Fetch budget data
    $budgetResponse = $httpClient->request('GET', 'http://127.0.0.1:8002/budget/api/get-data');
    $budgetData = $budgetResponse->toArray();

    // Extract budget amount
    $budgetAmount = 0;
    if (isset($budgetData['data']) && !empty($budgetData['data'])) {
        $budgetAmount = $budgetData['data'][0]['montant'] ?? 0;
    }

    // Fetch total expenses
    $expensesResponse = $httpClient->request('GET', 'http://127.0.0.1:8000/api/get-total-expenses');
    $expensesData = $expensesResponse->toArray();

    // Extract total expenses amount
    $expensesAmount = $expensesData['totalExpenses'] ?? 0;

    // Calculate savings
    $savingsValue = $budgetAmount - $expensesAmount;

    // Return savings as JSON response
    return $this->json(['savings' => $savingsValue]);
}




}
