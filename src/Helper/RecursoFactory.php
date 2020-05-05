<?php

namespace App\Helper;

use App\Entity\Recurso;

class RecursoFactory
{
    public function createRecurso(string $json)
    {
        $dataJson = json_decode($json);

        $recurso = new Recurso();
        $recurso->title = $dataJson->title;
        $recurso->description = $dataJson->description;
        $recurso->url = $dataJson->url;

        return $recurso;
    }
}