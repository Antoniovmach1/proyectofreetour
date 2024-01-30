<?php

namespace App\Entity;

use App\Repository\RutaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RutaRepository::class)]
class Ruta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $nombre = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $foto = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $punto_inicio = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function setFoto($foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getPuntoInicio()
    {
        return $this->punto_inicio;
    }

    public function setPuntoInicio($punto_inicio): static
    {
        $this->punto_inicio = $punto_inicio;

        return $this;
    }
}
