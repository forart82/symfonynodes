<?php

namespace App\Controller;

use App\Entity\SymfonyNodes;
use App\Entity\Texts;
use App\Entity\Types;
use App\Form\SymfonyNodesType;
use App\Repository\SymfonyNodesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\UniqueId;

/**
 * @Route("/symfonynodes")
 */
class SymfonyNodesController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    /**
     * @Route("/", name="symfony_nodes_index", methods={"GET"})
     */
    public function index(SymfonyNodesRepository $symfonyNodesRepository): Response
    {
        return $this->render('symfony_nodes/index.html.twig', [
            'symfony_nodes' => $symfonyNodesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="symfony_nodes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $uniqueId=UniqueId::createId();

        // Creation from type with two entitys
        // Entity 1: Text1
        // Entity 2: Text2
        $symfonyNode = new SymfonyNodes($this->em);
        $connections=[];

        if(100==$request->get('hiddeninput'))
        {
            $values=[
                'texts',
                'motifs',
                'strings',
                'types',
                'images',
            ];

            foreach($values as $value)
            {
                $connections[$value]=$request->get($value);
            }

        }

        $test="Types";
        $testobj= new $test();
        dd($testobj);

        $form = $this->createForm(SymfonyNodesType::class, $symfonyNode);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $text1->setSnid($uniqueId);
            // $text2->setSnid($uniqueId);
            // $type->setSnid($uniqueId);
            // $symfonyNode->setSnid($uniqueId);

            // $this->em->persist($symfonyNode);

            // $this->em->flush();


            // return $this->redirectToRoute('symfony_nodes_index');
        }

        return $this->render('symfony_nodes/new.html.twig', [
            'symfony_node' => $symfonyNode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="symfony_nodes_show", methods={"GET"})
     */
    public function show(SymfonyNodes $symfonyNode): Response
    {
        return $this->render('symfony_nodes/show.html.twig', [
            'symfony_node' => $symfonyNode,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="symfony_nodes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SymfonyNodes $symfonyNode): Response
    {
        $form = $this->createForm(SymfonyNodesType::class, $symfonyNode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('symfony_nodes_index');
        }

        return $this->render('symfony_nodes/edit.html.twig', [
            'symfony_node' => $symfonyNode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="symfony_nodes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SymfonyNodes $symfonyNode): Response
    {
        if ($this->isCsrfTokenValid('delete'.$symfonyNode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($symfonyNode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('symfony_nodes_index');
    }
}
