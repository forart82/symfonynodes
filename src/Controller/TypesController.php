<?php

namespace App\Controller;

use App\Entity\Types;
use App\Entity\Motifs;
use App\Form\TypesType;
use App\Entity\SymfonyNodes;
use App\Form\SymfonyNodesType;
use App\Repository\ImagesRepository;
use App\Services\Statics\SnValues;
use App\Services\Statics\UniqueId;
use App\Repository\TypesRepository;
use App\Repository\MotifsRepository;
use App\Repository\StringsRepository;
use App\Repository\SymfonyNodesRepository;
use App\Repository\TextsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @Route("/types")
 */
class TypesController extends AbstractController
{
    private $symfonyNodesRepository;
    private $typesRepository;
    private $motifsRepository;
    private $textsRepository;
    private $imagesRepository;
    private $stringsRepository;
    private $em;
    private $request;

    public function __construct(
        SymfonyNodesRepository $symfonyNodesRepository,
        TypesRepository $typesRepository,
        MotifsRepository $motifsRepository,
        TextsRepository $textsRepository,
        ImagesRepository $imagesRepository,
        StringsRepository $stringsRepository,
        EntityManagerInterface $em,
        RequestStack $requestStack
    ) {
        $this->symfonyNodesRepository = $symfonyNodesRepository;
        $this->typesRepository = $typesRepository;
        $this->motifsRepository = $motifsRepository;
        $this->textsRepository = $textsRepository;
        $this->imagesRepository = $imagesRepository;
        $this->stringsRepository = $stringsRepository;
        $this->em = $em;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @Route("/", name="types")
     */
    public function index(TypesRepository $typesRepository): Response
    {
        return $this->render('MAIN/INDEX.html.twig', [
            'elements' => $typesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="types_new", methods={"GET","POST"})
     */
    public function new(): Response
    {
        $values = SnValues::SNVALUES;
        $uniqueId = UniqueId::createId();
        $symfonyNode = new SymfonyNodes();
        $symfonyNode->setSnid($uniqueId);
        $motif = new Motifs();
        $motifs = [];
        $type = new Types();

        if (100 == $this->request->get('hiddeninput')) {
            foreach ($values as $value) {
                $temp = $this->request->get($value['method']);
                if (strlen($temp) > 0 && $value['method'] != 'getTypes') {
                    $motifs[] = $value['json'];
                    $class = $value['class'];
                    $entity = new $class();
                    $entity->setSnid($uniqueId);
                    $this->em->persist($entity);
                }
            }
            if (strlen($this->request->get('getTypes')) > 0) {
                $motif->setContent($motifs);
                $motif->setSnid($uniqueId);
                $this->em->persist($motif);

                $type->setContent($this->request->get('getTypes'));
                $type->setSnid($uniqueId);
                $this->em->persist($type);

                $this->em->persist($symfonyNode);
                $this->em->flush();
            }
            return $this->render('symfonynodes/type.html.twig', [
                'symfony_node' => $symfonyNode,
                'values' => $values,
                'created' => true,
                'motifs' => $motif,
                'type' => $type,
                'entity' => $entity,
            ]);
        }

        return $this->render('symfonynodes/type.html.twig', [
            'symfony_node' => $symfonyNode,
            'values' => $values,
        ]);
    }

    /**
     * @Route("/addcontent", name="types_add_content", methods={"GET","POST"})
     */
    public function addToContent(): Response
    {
        $values = SnValues::SNVALUES;
        $uniqueId = UniqueId::createId();
        $symfonyNode = new SymfonyNodes();
        $symfonyNode->setSnid($uniqueId);
        $motif = new Motifs();
        $motifs = [];
        $type = new Types();

        if (100 == $this->request->get('hiddeninput')) {
            foreach ($values as $value) {
                if (strlen($this->request->get($value['method'])) > 0) {
                    $motifs[] = $value['json'];
                    $class = $value['class'];
                    $entity = new $class();
                    $entity->setSnid($uniqueId);
                    $this->em->persist($entity);
                }
            }
            if (strlen($this->request->get('getTypes')) > 0) {
                $motif->setContent($motifs);
                $motif->setSnid($uniqueId);
                $this->em->persist($motif);

                $type->setContent($this->request->get('getTypes'));
                $type->setSnid($uniqueId);
                $this->em->persist($type);

                $this->em->persist($symfonyNode);
                $this->em->flush();
            }
            return $this->render('symfonynodes/type.html.twig', [
                'symfony_node' => $symfonyNode,
                'values' => $values,
                'created' => true,
            ]);
        }

        return $this->render('symfonynodes/type.html.twig', [
            'symfony_node' => $symfonyNode,
            'values' => $values,
        ]);
    }

    /**
     * @Route("/{snid}/{eid}/addentity", name="types_add_entity", methods={"GET","POST"})
     */
    public function addToEntity($snid, $eid): Response
    {
        $entity = null;
        $entitys = null;
        $values = SnValues::SNVALUES;
        $symfonyNode = $this->symfonyNodesRepository->findOneBySnid($snid);
        $type = $this->typesRepository->findOneBySnid($snid);
        $motif = $this->motifsRepository->findOneBySnid($snid);
        $motifs = $motif->getContent();



        if (100 == $this->request->get('hiddeninput')) {
            foreach ($values as $value) {

                if (strlen($this->request->get($value['method'])) > 0) {

                    $motifs[] = $value['json'];
                    $class = $value['class'];
                    $entity = new $class();
                    $entity->setSnid($snid);
                    $entity->setRelation($eid);
                    $this->em->persist($entity);
                }
            }

            $motif->setContent($motifs);
            $this->em->persist($motif);
            $this->em->flush();
            $motifs=array_unique($motifs);
            foreach ($motifs as $m) {
                $repository = strtolower($m) . 'Repository';
                foreach($this->$repository->findBySnid($snid) as $entity)
                {
                    $entitys[] = $entity;
                };
            }
            dump($motifs,$entitys);

            return $this->render('symfonynodes/type.html.twig', [
                'values' => $values,
                'created' => true,
                'motifs' => $motif,
                'type' => $type,
                'entitys' => $entitys,
            ]);
        }

        return $this->render('symfonynodes/type.html.twig', [
            'symfony_node' => $symfonyNode,
            'values' => $values,
        ]);
    }

    /**
     * @Route("/{id}/create", name="types_create", methods={"GET"})
     */
    public function create($id): Response
    {
        $uniqueId = UniqueId::createId();
        $symfonyNode = new SymfonyNodes($this->em);
        $connections = [];
        $values = SnValues::SNVALUES;

        $type = $this->typesRepository->findOneById($id);
        $snid = $type->getSnid();
        $motifs = $this->motifsRepository->findOneBySnid($snid);

        foreach ($motifs->getContent() as $motif) {
            $get = 'get' . $motif;
            $add = 'App\\Entity\\' . $motif;
            $symfonyNode->$get()->add(new $add());
        }
        $form = $this->createForm(SymfonyNodesType::class, $symfonyNode);
        $form->handleRequest($this->request);

        return $this->render('MAIN/NEW.html.twig', [
            'elements' => $symfonyNode,
            'form' => $form->createView(),
            'values' => $values,
        ]);
    }

    /**
     * @Route("/{id}", name="types_show", methods={"GET"})
     */
    public function show(Types $types): Response
    {
        return $this->render('MAIN/SHOW.html.twig', [
            'elements' => $types,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="types_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Types $types): Response
    {
        $form = $this->createForm(TypesType::class, $types);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('types');
        }

        return $this->render('MAIN/EDIT.html.twig', [
            'elements' => $types,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="types_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Types $types): Response
    {
        if ($this->isCsrfTokenValid('delete' . $types->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($types);
            $entityManager->flush();
        }

        return $this->redirectToRoute('types');
    }
}
