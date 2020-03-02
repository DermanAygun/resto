<?php

namespace App\Controller;

use App\Entity\MenuGerecht;
use App\Form\MenuGerechtType;
use App\Repository\MenuGerechtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/menu_gerecht")
 */
class MenuGerechtController extends AbstractController
{
    /**
     * @Route("/", name="menu_gerecht_index", methods={"GET"})
     */
    public function index(MenuGerechtRepository $menuGerechtRepository): Response
    {
        return $this->render('menu_gerecht/index.html.twig', [
            'menu_gerechts' => $menuGerechtRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="menu_gerecht_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $menuGerecht = new MenuGerecht();
        $form = $this->createForm(MenuGerechtType::class, $menuGerecht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($menuGerecht);
            $entityManager->flush();

            return $this->redirectToRoute('menu_gerecht_index');
        }

        return $this->render('menu_gerecht/new.html.twig', [
            'menu_gerecht' => $menuGerecht,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="menu_gerecht_show", methods={"GET"})
     */
    public function show(MenuGerecht $menuGerecht): Response
    {
        return $this->render('menu_gerecht/show.html.twig', [
            'menu_gerecht' => $menuGerecht,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="menu_gerecht_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, MenuGerecht $menuGerecht): Response
    {
        $form = $this->createForm(MenuGerechtType::class, $menuGerecht);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('menu_gerecht_index');
        }

        return $this->render('menu_gerecht/edit.html.twig', [
            'menu_gerecht' => $menuGerecht,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="menu_gerecht_delete", methods={"DELETE"})
     */
    public function delete(Request $request, MenuGerecht $menuGerecht): Response
    {
        if ($this->isCsrfTokenValid('delete'.$menuGerecht->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($menuGerecht);
            $entityManager->flush();
        }

        return $this->redirectToRoute('menu_gerecht_index');
    }
}
