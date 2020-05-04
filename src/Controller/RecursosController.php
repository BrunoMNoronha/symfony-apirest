<?php

namespace App\Controller;

use App\Entity\Recurso;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecursosController
{
    /**
     * @Route("/api/recursos", methods={POST})
     */
    public function store(Request $request): Response
    {
        $requestBody = $request->getContent();
        $dataJson = json_decode($requestBody);

        $recurso = new Recurso();
        $recurso->title = $dataJson->title;
        $recurso->description = $dataJson->description;
        $recurso->url = $dataJson->url;

        return new JsonResponse($recurso);
    }
}