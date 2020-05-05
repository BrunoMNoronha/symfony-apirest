<?php

namespace App\Controller;

use App\Entity\Recurso;
use App\Helper\RecursoFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecursosController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var RecursoFactory
     */
    private $recursoFactory;

    public function __construct(EntityManagerInterface $entityManager, RecursoFactory $recursoFactory)
    {
        $this->entityManager = $entityManager;
        $this->recursoFactory = $recursoFactory;
    }

    /**
     * @Route("/api/recursos", methods={"GET"})
     */
    public function index(): Response
    {
        $recursoRepository = $this->getDoctrine()->getRepository(Recurso::class);
        $recursos = $recursoRepository->findAll();

        return new JsonResponse($recursos);
    }

    /**
     * @Route("/api/recursos/{id}", methods={"GET"})
     */
    public function show(Request $request, int $id): Response
    {
        $recurso = $this->getRecurso($id);

        $statusCode = is_null($recurso) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse($recurso, $statusCode);
    }

    /**
     * @Route("/api/recursos", methods={"POST"})
     */
    public function store(Request $request): Response
    {
        $requestBody = $request->getContent();
        $recurso = $this->recursoFactory->createRecurso($requestBody);

        $this->entityManager->persist($recurso);
        $this->entityManager->flush();

        return new JsonResponse($recurso);
    }

    /**
     * @Route("/api/recursos/{id}", methods={"PUT"})
     */
    public function update(Request $request, int $id): Response
    {
        $requestBody = $request->getContent();
        $newRecurso = $this->recursoFactory->createRecurso($requestBody);

        $recurso = $this->getRecurso($id);
        if (is_null($recurso)){
            return new Response('', Response::HTTP_NOT_FOUND);
        }

        $recurso->title = $newRecurso->title;
        $recurso->description = $newRecurso->description;
        $recurso->url = $newRecurso->url;

        $this->entityManager->flush();

        return new JsonResponse($recurso);
    }

    public function destroy()
    {
        
    }

    /**
     * @param int $id
     * @return object|null
     */
    public function getRecurso(int $id)
    {
        $recursoRepository = $this->getDoctrine()->getRepository(Recurso::class);
        $recurso = $recursoRepository->find($id);
        return $recurso;
    }
}