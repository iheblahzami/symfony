<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\Transaction1Type;
use App\Repository\TransactionRepository;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/transaction")
 */
class TransactionController extends AbstractController
{
    /**
     * @Route("/", name="app_transaction_index", methods={"GET"})
     */
    public function index(TransactionRepository $transactionRepository): Response
    {
        return $this->render('transaction/index.html.twig', [
            'transactions' => $transactionRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_transaction_new", methods={"GET", "POST"})
     */
    public function new(Request $request, TransactionRepository $transactionRepository): Response
    {
        
        $transaction = new Transaction();
        $form = $this->createForm(Transaction1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->add($transaction, true);

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transaction/new.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_transaction_show", methods={"GET"})
     */
    public function show(Transaction $transaction): Response
    {
        return $this->render('transaction/show.html.twig', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_transaction_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Transaction $transaction, TransactionRepository $transactionRepository): Response
    {
        $form = $this->createForm(Transaction1Type::class, $transaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $transactionRepository->add($transaction, true);

            return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('transaction/edit.html.twig', [
            'transaction' => $transaction,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_transaction_delete", methods={"POST"})
     */
    public function delete(Request $request, Transaction $transaction, TransactionRepository $transactionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transaction->getId(), $request->request->get('_token'))) {
            $transactionRepository->remove($transaction, true);
        }

        return $this->redirectToRoute('app_transaction_index', [], Response::HTTP_SEE_OTHER);
    }












/**
 * @Route("/consume/budget/{id}", name="consume_budget")
 */

 public function consumeShowBudget(Request $request, int $id): Response
{
$httpClient = HttpClient::create();
    $response = $httpClient->request('GET', 'http://127.0.0.1:8000/budget/{$id}');
    $data = $response->toArray();

    return $this->json($data);
    
}



























/**
 * @Route("/consume/api/data", name="consume_api_data")
 */

 public function consumeApiData(Request $request): Response
{
    $httpClient = HttpClient::create();
    $response = $httpClient->request('GET', 'http://127.0.0.1:8000/budget/api/data');
    $data = $response->toArray();
    $form = $this->createFormBuilder()
        ->add('nomCategorie', ChoiceType::class, [
            'label' => 'Nom Categorie',
            'choices' => array_combine($data['categories'], $data['categories']),
 // Assuming $data contains the categories
        ])
        ->add('montant', TextType::class, [
            'label' => 'Montant',
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Submit',
        ])
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $data = $form->getData();

        // Here, you can send $data to the budget microservice as needed
        // For simplicity, we'll just return a success message
        return new Response('Form submitted successfully!');
    }

    // Render the form template as HTML
    return $this->render('consume_api/form.html.twig', [
        'form' => $form->createView(),
    ]);

}


/* $httpClient = HttpClient::create();
    $response = $httpClient->request('GET', 'http://localhost:8000/api/data');
    $data = $response->toArray();

    return $this->json($data);
    */





}
