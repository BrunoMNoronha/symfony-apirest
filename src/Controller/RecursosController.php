<?php

namespace App\Controller;

use App\Entity\Recurso;
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

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
    public function show(Request $request): Response
    {
        $id = $request->get('id');
        $recursoRepository = $this->getDoctrine()->getRepository(Recurso::class);
        $recurso = $recursoRepository->find($id);

        $statusCode = is_null($recurso) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK;

        return new JsonResponse($recurso, $statusCode);
    }

    /**
     * @Route("/api/recursos", methods={"POST"})
     */
    public function store(Request $request): Response
    {
        $requestBody = $request->getContent();
        $dataJson = json_decode($requestBody);

        $recurso = new Recurso();
        $recurso->title = $dataJson->title;
        $recurso->description = $dataJson->description;
        $recurso->url = $dataJson->url;

        $this->entityManager->persist($recurso);
        $this->entityManager->flush();

        return new JsonResponse($recurso);
    }

    /**
     * @Route("/api/recursos/{id}", methods={"PUT"})
     */
    public function update(Request $request): Response
    {
        $id = $request->get('id');

        $requestBody = $request->getContent();
        $dataJson = json_decode($requestBody);

        $newRecurso = new Recurso();
        $newRecurso->title = $dataJson->title;
        $newRecurso->description = $dataJson->description;
        $newRecurso->url = $dataJson->url;

        $recursoRepository = $this->getDoctrine()->getRepository(Recurso::class);
        $recurso = $recursoRepository->find($id);
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
}