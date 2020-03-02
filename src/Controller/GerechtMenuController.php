<?php

namespace App\Controller;

use App\Entity\GerechtMenu;
use App\Form\GerechtMenuType;
use App\Repository\GerechtMenuRepository;
use App\Repository\GerechtRepository;
use App\Repository\MenuItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/gerecht-menu")
 */
class GerechtMenuController extends AbstractController
{
    /**
     * @Route("/", name="gerecht_menu_index", methods={"GET"})
     */
    public function index(GerechtMenuRepository $gerechtMenuRepository): Response
    {

        return $this->render('gerecht_menu/index.html.twig', [
            'gerecht_menus' => $gerechtMenuRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="gerecht_menu_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gerechtMenu = new GerechtMenu();
        $form = $this->createForm(GerechtMenuType::class, $gerechtMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gerechtMenu);
            $entityManager->flush();

            return $this->redirectToRoute('gerecht_menu_index');
        }

        return $this->render('gerecht_menu/new.html.twig', [
            'gerecht_menu' => $gerechtMenu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gerecht_menu_show", methods={"GET"})
     */
    public function show(GerechtMenu $gerechtMenu): Response
    {
        return $this->render('gerecht_menu/show.html.twig', [
            'gerecht_menu' => $gerechtMenu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="gerecht_menu_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GerechtMenu $gerechtMenu): Response
    {
        $form = $this->createForm(GerechtMenuType::class, $gerechtMenu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gerecht_menu_index', [
                'id' => $gerechtMenu->getId(),
            ]);
        }

        return $this->render('gerecht_menu/edit.html.twig', [
            'gerecht_menu' => $gerechtMenu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gerecht_menu_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GerechtMenu $gerechtMenu): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gerechtMenu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gerechtMenu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gerecht_menu_index');
    }
}
