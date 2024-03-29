<?php

namespace App\Entity;

use App\Repository\InformeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformeRepository::class)]
class Informe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $foto = null;

    #[ORM\Column(length: 40, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\Column]
    private ?int $recaudacion = null;

    #[ORM\ManyToOne(inversedBy: 'informes')]
    private ?Tour $Tour = null;

    #[ORM\Column]
    private ?int $presentes = null;

   

    public function getId(): ?int
    {
        return $this->id;
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

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): static
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    public function getRecaudacion(): ?int
    {
        return $this->recaudacion;
    }

    public function setRecaudacion(int $recaudacion): static
    {
        $this->recaudacion = $recaudacion;

        return $this;
    }

    public function getTour(): ?Tour
    {
        return $this->Tour;
    }

    public function setTour(?Tour $Tour): static
    {
        $this->Tour = $Tour;

        return $this;
    }

    public function getPresentes(): ?int
    {
        return $this->presentes;
    }

    public function setPresentes(int $presentes): static
    {
        $this->presentes = $presentes;

        return $this;
    }

   
}
