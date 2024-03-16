<?php

namespace App\Controller;

use App\Entity\WishList;
use App\Form\WishListType;
use App\Repository\WishListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wish/list")
 */
class WishListController extends AbstractController
{
    /**
     * @Route("/", name="app_wish_list_index", methods={"GET"})
     */
    public function index(WishListRepository $wishListRepository): Response
    {
        return $this->render('wish_list/index.html.twig', [
            'wish_lists' => $wishListRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_wish_list_new", methods={"GET", "POST"})
     */
    public function new(Request $request, WishListRepository $wishListRepository): Response
    {
        $wishList = new WishList();
        $form = $this->createForm(WishListType::class, $wishList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wishListRepository->add($wishList, true);

            return $this->redirectToRoute('app_wish_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wish_list/new.html.twig', [
            'wish_list' => $wishList,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_wish_list_show", methods={"GET"})
     */
    public function show(WishList $wishList): Response
    {
        return $this->render('wish_list/show.html.twig', [
            'wish_list' => $wishList,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_wish_list_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, WishList $wishList, WishListRepository $wishListRepository): Response
    {
        $form = $this->createForm(WishListType::class, $wishList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wishListRepository->add($wishList, true);

            return $this->redirectToRoute('app_wish_list_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('wish_list/edit.html.twig', [
            'wish_list' => $wishList,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_wish_list_delete", methods={"POST"})
     */
    public function delete(Request $request, WishList $wishList, WishListRepository $wishListRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wishList->getId(), $request->request->get('_token'))) {
            $wishListRepository->remove($wishList, true);
        }

        return $this->redirectToRoute('app_wish_list_index', [], Response::HTTP_SEE_OTHER);
    }
}
