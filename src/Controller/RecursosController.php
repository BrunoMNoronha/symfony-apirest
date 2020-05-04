<?php

namespace App\Controller;

use App\Entity\Recurso;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecursosController
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
}