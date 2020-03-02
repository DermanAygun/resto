<?php

namespace App\Controller;

use App\Entity\Barman;
use App\Form\BarmanType;
use App\Repository\BarmanRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/barman")
 */
class BarmanController extends AbstractController
{
    /**
     * @Route("/", name="barman_index", methods={"GET"})
     */
    public function index(BarmanRepository $barmanRepository): Response
    {
        return $this->render('barman/index.html.twig', [
            'barmen' => $barmanRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="barman_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $barman = new Barman();
        $form = $this->createForm(BarmanType::class, $barman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($barman);
            $entityManager->flush();

            return $this->redirectToRoute('barman_index');
        }

        return $this->render('barman/new.html.twig', [
            'barman' => $barman,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="barman_show", methods={"GET"})
     */
    public function show(Barman $barman): Response
    {
        return $this->render('barman/show.html.twig', [
            'barman' => $barman,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="barman_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Barman $barman): Response
    {
        $form = $this->createForm(BarmanType::class, $barman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('barman_index');
        }

        return $this->render('barman/edit.html.twig', [
            'barman' => $barman,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="barman_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Barman $barman): Response
    {
        if ($this->isCsrfTokenValid('delete'.$barman->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($barman);
            $entityManager->flush();
        }

        return $this->redirectToRoute('barman_index');
    }
}
