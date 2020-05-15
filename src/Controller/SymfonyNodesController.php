<?php

namespace App\Controller;

use App\Entity\Types;
use App\Entity\Motifs;
use App\Entity\SymfonyNodes;
use App\Form\SymfonyNodesType;
use App\Services\Statics\SnValues;
use App\Services\Statics\UniqueId;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\SymfonyNodesRepository;
use App\Repository\TypesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/symfonynodes")
 */
class SymfonyNodesController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/", name="symfonynodes_index", methods={"GET"})
     */
    public function index(TypesRepository $typesRepository): Response
    {
        return $this->render('MAIN/INDEX.html.twig', [
            'elements' => $typesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/type", name="symfonynodes_type", methods={"GET","POST"})
     */
    public function type(Request $request): Response
    {
        $values=SnValues::SNVALUES;
        $uniqueId = UniqueId::createId();
        $symfonyNode = new SymfonyNodes();
        $symfonyNode->setSnid($uniqueId);
        $motif=new Motifs();
        $motifs=[];
        $type=new Types();
        $connections = [];

        if (100 == $request->get('hiddeninput')) {
            foreach ($values as $key => $value) {
                $connections[$key] = $request->get($value['method']);
                for ($i = 0; $i < (int)$connections[$key]; $i++) {
                    $motifs[]=$value['json'];
                    $class=$value['class'];
                    $entity=new $class();
                    $entity->setSnid($uniqueId);
                    $this->em->persist($entity);
                }
            }
            if(strlen($request->get('getTypes'))>0)
            {
                $motif->setContent($motifs);
                $motif->setSnid($uniqueId);
                $this->em->persist($motif);

                $type->setContent($request->get('getTypes'));
                $type->setSnid($uniqueId);
                $this->em->persist($type);

                $this->em->persist($symfonyNode);
                $this->em->flush();
            }


        }

        return $this->render('symfonynodes/type.html.twig', [
            'symfony_node' => $symfonyNode,
            'values'=>$values,
        ]);
    }

    /**
     * @Route("/new", name="symfonynodes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $uniqueId = UniqueId::createId();
        $symfonyNode = new SymfonyNodes($this->em);
        $connections = [];
        $values=SnValues::SNVALUES;
        if (100 == $request->get('hiddeninput')) {
            foreach ($values as $key => $value) {
                $connections[$key] = $request->get($value['method']);
                for ($i = 0; $i < (int)$connections[$key]; $i++) {
                    $get=$value['method'];
                    $add=$value['class'];
                    $symfonyNode->$get()->add(new $add());
                }
            }
        }
        $form = $this->createForm(SymfonyNodesType::class, $symfonyNode);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getExtraData()['texts'][0]);
            foreach ($values as $key => $value) {
                $elementsToSet=$form->getExtraData(strtolower($value[2]));
                foreach ($elementsToSet as $key => $content) {
                    $obj=$value[1];
                    $object=new $obj();
                    $object->setSnid($uniqueId);
                    $object->setContent($content[0]['content']);
                    $this->em->persist($object);
                    $this->em->flush();
                }
            }
            $symfonyNode->setSnid($uniqueId);
            $this->em->persist($symfonyNode);
            $this->em->flush();
        }
        return $this->render('symfonynodes/new.html.twig', [
            'symfony_node' => $symfonyNode,
            'form' => $form->createView(),
            'values'=>$values,
        ]);
    }

    /**
     * @Route("/{id}", name="symfonynodes_show", methods={"GET"})
     */
    public function show(SymfonyNodes $symfonyNode): Response
    {
        return $this->render('symfonynodes/show.html.twig', [
            'symfony_node' => $symfonyNode,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="symfonynodes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SymfonyNodes $symfonyNode): Response
    {
        $form = $this->createForm(SymfonyNodesType::class, $symfonyNode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('symfonynodes_index');
        }

        return $this->render('symfonynodes/edit.html.twig', [
            'symfony_node' => $symfonyNode,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="symfonynodes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SymfonyNodes $symfonyNode): Response
    {
        if ($this->isCsrfTokenValid('delete' . $symfonyNode->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($symfonyNode);
            $entityManager->flush();
        }

        return $this->redirectToRoute('symfonynodes_index');
    }
}
