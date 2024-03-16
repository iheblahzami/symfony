<?php

namespace App\Controller;

use App\Entity\Expenses;
use App\Form\ExpensesType;
use App\Repository\ExpensesRepository;
use App\Repository\TransactionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Transaction;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/expenses")
 */
class ExpensesController extends AbstractController
{



/**
     * @Route("/calculate-expenses", name="calculate_expenses")
     */
    public function calculateExpenses(ExpensesRepository $expensesRepository, TransactionRepository $transactionRepository): Response
    {
        // Fetch all transactions from the database
        $transactions = $transactionRepository->findAll();

        // Calculate the total sum of montant values
        $totalExpenses = array_sum(array_map(function (Transaction $transaction) {
            return $transaction->getMontant();
        }, $transactions));

        // Create or fetch an Expenses entity and set the montantTotal
        $expenses = $expensesRepository->findOrCreateExpenses();
        $expenses->setMontantTotal($totalExpenses);

        // Save the Expenses entity
        $entityManager = $this->getDoctrine()->getManager();
        $expensesRepository->add($expenses, true);
                $entityManager->flush();
    // Fetch all expenses (including the newly created/updated one)
    $allExpenses = $expensesRepository->findAll();

        // Pass expenses variable to the template
    return $this->render('expenses/index.html.twig', [
        'expenses' => $allExpenses,
        'totalExpenses' => $totalExpenses,
    ]);
    }



    /**
 * @Route("/api/get-total-expenses", name="get_total_expenses", methods={"GET"})
 */
public function getTotalExpenses(TransactionRepository $transactionRepository): JsonResponse
{
    // Fetch all transactions from the database
    $transactions = $transactionRepository->findAll();

    // Calculate the total sum of montant values
    $totalExpenses = array_sum(array_map(function (Transaction $transaction) {
        return $transaction->getMontant();
    }, $transactions));

    // Return the total expenses as JSON response
    return $this->json(['totalExpenses' => $totalExpenses]);
}





 




    /**
 * @Route("/{id}", name="app_expenses_show", methods={"GET"})
 */
public function show(Expenses $expense): Response
{
    return $this->render('expenses/show.html.twig', [
        'expense' => $expense,
    ]);
}
/**
 * @Route("/", name="app_expenses_index", methods={"GET"})
 */
public function index(ExpensesRepository $expensesRepository): Response
{
    return $this->render('expenses/index.html.twig', [
        'expenses' => $expensesRepository->findAll(),
    ]);
}


/**
     * @Route("/{id}/edit", name="app_expenses_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Expenses $expense, ExpensesRepository $expensesRepository): Response
    {
        $form = $this->createForm(ExpensesType::class, $expense);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $expensesRepository->add($expense, true);

            return $this->redirectToRoute('app_expenses_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('expenses/edit.html.twig', [
            'expense' => $expense,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_expenses_delete", methods={"POST"})
     */
    public function delete(Request $request, Expenses $expense, ExpensesRepository $expensesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$expense->getId(), $request->request->get('_token'))) {
            $expensesRepository->remove($expense, true);
        }

        return $this->redirectToRoute('app_expenses_index', [], Response::HTTP_SEE_OTHER);
    }




   

    
}
