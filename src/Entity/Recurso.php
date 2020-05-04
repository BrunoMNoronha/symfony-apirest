<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Recurso
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $id;
    /**
     * @ORM\Column(type="string")
     */
    public $title;
    /**
     * @ORM\Column(type="string")
     */
    public $description;
    /**
     * @ORM\Column(type="string")
     */
    public $url;
}