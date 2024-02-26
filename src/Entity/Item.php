<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private $foto = null;

    
    #[ORM\Column]
    private array $localizacion = [];

    // #[ORM\Column(length: 255, nullable: true)]
    // private $localizacion = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    private ?Localidad $Localidad = null;

    #[ORM\ManyToMany(targetEntity: Ruta::class, inversedBy: 'items')]
    private Collection $Ruta;


    public function __construct()
    {
        $this->Ruta = new ArrayCollection();
    }

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

    // public function getLocalizacion()
    // {
    //     return $this->localizacion;
    // }

    // public function setLocalizacion($localizacion): static
    // {
    //     $this->localizacion = $localizacion;

    //     return $this;
    // }

    public function getLocalidad(): ?Localidad
    {
        return $this->Localidad;
    }

    public function setLocalidad(?Localidad $Localidad): static
    {
        $this->Localidad = $Localidad;

        return $this;
    }

    /**
     * @return Collection<int, Ruta>
     */
    public function getRuta(): Collection
    {
        return $this->Ruta;
    }

    public function addRutum(Ruta $rutum): static
    {
        if (!$this->Ruta->contains($rutum)) {
            $this->Ruta->add($rutum);
        }

        return $this;
    }

    public function removeRutum(Ruta $rutum): static
    {
        $this->Ruta->removeElement($rutum);

        return $this;
    }

    public function getLocalizacion(): array
    {
        return $this->localizacion;
    }

    public function setLocalizacion(array $localizacion): static
    {
        $this->localizacion = $localizacion;

        return $this;
    }
}