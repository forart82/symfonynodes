<?php

namespace App\Controller;

use App\Entity\Texts;
use App\Form\TextsType;
use App\Repository\TextsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/texts")
 */
class TextsController extends AbstractController
{
    /**
     * @Route("/", name="texts_index", methods={"GET"})
     */
    public function index(TextsRepository $textsRepository): Response
    {
        return $this->render('texts/index.html.twig', [
            'texts' => $textsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="texts_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $text = new Texts();
        $form = $this->createForm(TextsType::class, $text);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($text);
            $entityManager->flush();

            return $this->redirectToRoute('texts_index');
        }

        return $this->render('texts/new.html.twig', [
            'text' => $text,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="texts_show", methods={"GET"})
     */
    public function show(Texts $text): Response
    {
        return $this->render('texts/show.html.twig', [
            'text' => $text,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="texts_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Texts $text): Response
    {
        $form = $this->createForm(TextsType::class, $text);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('texts_index');
        }

        return $this->render('texts/edit.html.twig', [
            'text' => $text,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="texts_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Texts $text): Response
    {
        if ($this->isCsrfTokenValid('delete'.$text->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($text);
            $entityManager->flush();
        }

        return $this->redirectToRoute('texts_index');
    }
}
