<?php

namespace App\Controller;

use App\Entity\Budget;
use App\Form\BudgetType;
use App\Repository\BudgetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategorieBudgetRepository;
use App\Entity\CategorieBudget;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use OldSound\RabbitMqBundle\RabbitMq\Producer;
use App\DTO\TransactionDTO;
{

/**
 * @Route("/budget")
 */
class BudgetController extends AbstractController{
    /**
     * @Route("/get", name="app_budget_index", methods={"GET"})
     */
    public function index(BudgetRepository $budgetRepository): Response
    {
        $budgets = $budgetRepository->findAllWithCategories();
        return $this->render('budget/index.html.twig', [
            'budgets' => $budgets,
                ]);
    }

    /**
     * @Route("/new", name="app_budget_new", methods={"GET", "POST"})
     */
    public function new(Request $request, BudgetRepository $budgetRepository, CategorieBudgetRepository $categorieBudgetRepository): Response
    {
        $budget = new Budget();

        // Fetch available CategorieBudget options
        $categories = $categorieBudgetRepository->findAll();

        $form = $this->createForm(BudgetType::class, $budget, [
            'categories' => $categories, // Pass the categories to the form
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newCategorie = $form->get('newCategorie')->getData();

            if (!empty($newCategorie)) {
                
                // If a new category is entered, create and persist it
                $categorie = new CategorieBudget();
                $categorie->setNomCategorie($newCategorie);
    
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($categorie);

     // Set the category on the budget before submitting the form
     $budget->setCategorie($categorie);
            }
    
            $budgetRepository->add($budget, true);
            return $this->redirectToRoute('app_budget_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('budget/new.html.twig', [
            'budget' => $budget,
            'form' => $form,
        ]);
    }


    //affichageeeee
    /**
     * @Route("/{id}", name="app_budget_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
       /* return $this->render('budget/show.html.twig', [
            'budget' => $budget,
        ]);
        */
        {
            $budget = $this->getDoctrine()->getRepository(Budget::class)->find($id);

    if (!$budget) {
        throw $this->createNotFoundException('Budget not found');
    }
            // Prepare the data to be returned in JSON format
            $data = [
                'id' => $budget->getId(),
                'montant' => $budget->getMontant(),
                'categorie' => $budget->getCategorie() ? $budget->getCategorie()->getNomCategorie() : null,
                // Add more properties as needed
            ];
        
            // Return the data as JSON response
            return new JsonResponse($data);
        }
    }

















   /**
 * @Route("/{id}/edit", name="app_budget_edit", methods={"GET", "POST"})
 */
public function edit(Request $request, Budget $budget, BudgetRepository $budgetRepository, CategorieBudgetRepository $categorieBudgetRepository): Response
{
    // Fetch available CategorieBudget options
    $categories = $categorieBudgetRepository->findAll();

    $form = $this->createForm(BudgetType::class, $budget, [
        'categories' => $categories, // Pass the categories to the form
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $newCategorie = $form->get('newCategorie')->getData();

        if (!empty($newCategorie)) {
            // If a new category is entered, create and persist it
            $categorie = new CategorieBudget();
            $categorie->setNomCategorie($newCategorie);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);

            // Update the budget entity with the new category
            $budget->setCategorie($categorie);
        }

        $budgetRepository->add($budget, true);

        return $this->redirectToRoute('app_budget_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('budget/edit.html.twig', [
        'budget' => $budget,
        'form' => $form,
    ]);
}

/**

     * @Route("/{id}", name="app_budget_delete", methods={"POST"})
     */
    public function delete(Request $request, Budget $budget, BudgetRepository $budgetRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$budget->getId(), $request->request->get('_token'))) {
            $budgetRepository->remove($budget, true);
        }

        return $this->redirectToRoute('app_budget_index', [], Response::HTTP_SEE_OTHER);
    }



 /**
 * @Route("/{id}/montant-budget", name="app_budget_display_montant", methods={"GET"})
 */
public function displayMontant(Budget $budget): JsonResponse
{
    $montant = $budget->getMontant();

    return $this->json(['montant' => $montant]);
}  


  



    /**
     * @Route("/api/data", name="api_data")
     */
    public function getData(): JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $budgetRepository = $entityManager->getRepository(Budget::class);
        $budgetData = $budgetRepository->findAllWithCategories();

        // Extracting 'nomBudget' and 'montant' from Budget entities
        $formattedData = [];
        foreach ($budgetData as $budget) {
            $formattedData[] = 
              
             $budget->getCategorie()->getNomCategorie();
               
            
        }

        return $this->json(['categories' => $formattedData]);
    }




    /**
 * @Route("/api/get-data", name="get_montant_budget", methods={"GET"})
 */
public function getMontantBudget(BudgetRepository $budgetRepository): JsonResponse
{
    // Fetch all budgets with categories
    $budgetData = $budgetRepository->findAll();

    // Extracting 'nomCategorie' and 'montant' from Budget entities
    $formattedData = [];
    foreach ($budgetData as $budget) {
        $formattedData[] = [
            'montant' => $budget->getMontant(),
        ];
    }

    return $this->json(['data' => $formattedData]);
}





  

}






}