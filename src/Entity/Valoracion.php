<?php

namespace App\Entity;

use App\Repository\ValoracionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ValoracionRepository::class)]
class Valoracion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $valoracion_guia = null;

    #[ORM\Column(nullable: true)]
    private ?int $valoracion_ruta = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $comentario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValoracionGuia(): ?int
    {
        return $this->valoracion_guia;
    }

    public function setValoracionGuia(?int $valoracion_guia): static
    {
        $this->valoracion_guia = $valoracion_guia;

        return $this;
    }

    public function getValoracionRuta(): ?int
    {
        return $this->valoracion_ruta;
    }

    public function setValoracionRuta(?int $valoracion_ruta): static
    {
        $this->valoracion_ruta = $valoracion_ruta;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(?string $comentario): static
    {
        $this->comentario = $comentario;

        return $this;
    }
}
