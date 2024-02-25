<?php

namespace App\Entity;

use App\Repository\RutaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private $foto = null;

    #[ORM\Column(nullable: true)]
    private array $punto_inicio = [];

    #[ORM\ManyToMany(targetEntity: Item::class, mappedBy: 'Ruta')]
    private Collection $items;

    #[ORM\OneToMany(mappedBy: 'Ruta', targetEntity: Tour::class)]
    private Collection $Tours;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_ini = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha_fin = null;

    #[ORM\Column(length: 10)]
    private ?int $aforo = null;

    #[ORM\Column(nullable: true)]
    private array $programacion = [];

    public function __construct()
    {
        $this->items = new ArrayCollection();
        $this->Tours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

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

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): static
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->addRutum($this);
        }

        return $this;
    }

    public function removeItem(Item $item): static
    {
        if ($this->items->removeElement($item)) {
            $item->removeRutum($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Tour>
     */
    public function getTours(): Collection
    {
        return $this->Tours;
    }

    public function addTour(Tour $Tour): static
    {
        if (!$this->Tours->contains($Tour)) {
            $this->Tours->add($Tour);
            $Tour->setRuta($this);
        }

        return $this;
    }

    public function removeTour(Tour $Tour): static
    {
        if ($this->Tours->removeElement($Tour)) {
          
            if ($Tour->getRuta() === $this) {
                $Tour->setRuta(null);
            }
        }

        return $this;
    }

    public function getFechaIni(): ?\DateTimeInterface
    {
        return $this->fecha_ini;
    }

    public function setFechaIni(\DateTimeInterface $fecha_ini): static
    {
        $this->fecha_ini = $fecha_ini;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(\DateTimeInterface $fecha_fin): static
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }

    public function getAforo(): ?int
    {
        return $this->aforo;
    }

    public function setAforo(int $aforo): static
    {
        $this->aforo = $aforo;

        return $this;
    }

    public function getProgramacion(): array
    {
        return $this->programacion;
    }

    public function setProgramacion(array $programacion): static
    {
        $this->programacion = $programacion;

        return $this;
    }

    public function __toString()
    {
        return $this->getFechaIni();
    }
}
