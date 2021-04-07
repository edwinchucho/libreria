<?php


namespace App\Entity\util;


use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait timestamable
{
    /**
     * @Gedmo\Timestampable (on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $creado;

    public function getCreado(): ?\DateTimeInterface
    {
        return $this->creado;
    }

}