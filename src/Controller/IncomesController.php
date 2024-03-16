<?php

namespace App\Controller;

use App\Entity\Incomes;
use App\Form\IncomesType;
use App\Repository\IncomesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/incomes")
 */
class IncomesController extends AbstractController
{
    /**
     * @Route("/", name="app_incomes_index", methods={"GET"})
     */
    public function index(IncomesRepository $incomesRepository): Response
    {
        return $this->render('incomes/index.html.twig', [
            'incomes' => $incomesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_incomes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, IncomesRepository $incomesRepository): Response
    {
        $income = new Incomes();
        $form = $this->createForm(IncomesType::class, $income);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $incomesRepository->add($income, true);

            return $this->redirectToRoute('app_incomes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('incomes/new.html.twig', [
            'income' => $income,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_incomes_show", methods={"GET"})
     */
    public function show(Incomes $income): Response
    {
        return $this->render('incomes/show.html.twig', [
            'income' => $income,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_incomes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Incomes $income, IncomesRepository $incomesRepository): Response
    {
        $form = $this->createForm(IncomesType::class, $income);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $incomesRepository->add($income, true);

            return $this->redirectToRoute('app_incomes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('incomes/edit.html.twig', [
            'income' => $income,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_incomes_delete", methods={"POST"})
     */
    public function delete(Request $request, Incomes $income, IncomesRepository $incomesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$income->getId(), $request->request->get('_token'))) {
            $incomesRepository->remove($income, true);
        }

        return $this->redirectToRoute('app_incomes_index', [], Response::HTTP_SEE_OTHER);
    }
}
