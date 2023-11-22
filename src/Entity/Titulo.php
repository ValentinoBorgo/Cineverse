<?php

namespace App\Entity;

use App\Repository\TituloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TituloRepository::class)]
class Titulo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tipo = null;

    #[ORM\Column(length: 255)]
    private ?string $genero = null;

    #[ORM\Column(length: 255)]
    private ?string $director = null;

    #[ORM\Column(length: 255)]
    private ?string $actores_principales = null;

    #[ORM\Column]
    private ?int $año_lanzamiento = null;

    #[ORM\Column]
    private ?int $cantidad_capitulos = null;

    #[ORM\Column]
    private ?int $me_gusta = null;

    #[ORM\Column(length: 255)]
    private ?string $comentario = null;

    #[ORM\Column]
    private ?bool $premium = null;

    #[ORM\ManyToMany(targetEntity: Cliente::class, mappedBy: 'ClienteTitulo')]
    private Collection $TituloCliente;

    public function __construct()
    {
        $this->TituloCliente = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(?string $tipo): static
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getGenero(): ?string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): static
    {
        $this->genero = $genero;

        return $this;
    }

    public function getDirector(): ?string
    {
        return $this->director;
    }

    public function setDirector(string $director): static
    {
        $this->director = $director;

        return $this;
    }

    public function getActoresPrincipales(): ?string
    {
        return $this->actores_principales;
    }

    public function setActoresPrincipales(string $actores_principales): static
    {
        $this->actores_principales = $actores_principales;

        return $this;
    }

    public function getAñoLanzamiento(): ?int
    {
        return $this->año_lanzamiento;
    }

    public function setAñoLanzamiento(int $año_lanzamiento): static
    {
        $this->año_lanzamiento = $año_lanzamiento;

        return $this;
    }

    public function getCantidadCapitulos(): ?int
    {
        return $this->cantidad_capitulos;
    }

    public function setCantidadCapitulos(int $cantidad_capitulos): static
    {
        $this->cantidad_capitulos = $cantidad_capitulos;

        return $this;
    }

    public function getMeGusta(): ?int
    {
        return $this->me_gusta;
    }

    public function setMeGusta(int $me_gusta): static
    {
        $this->me_gusta = $me_gusta;

        return $this;
    }

    public function getComentario(): ?string
    {
        return $this->comentario;
    }

    public function setComentario(string $comentario): static
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function isPremium(): ?bool
    {
        return $this->premium;
    }

    public function setPremium(bool $premium): static
    {
        $this->premium = $premium;

        return $this;
    }

    /**
     * @return Collection<int, Cliente>
     */
    public function getTituloCliente(): Collection
    {
        return $this->TituloCliente;
    }

    public function addTituloCliente(Cliente $tituloCliente): static
    {
        if (!$this->TituloCliente->contains($tituloCliente)) {
            $this->TituloCliente->add($tituloCliente);
            $tituloCliente->addClienteTitulo($this);
        }

        return $this;
    }

    public function removeTituloCliente(Cliente $tituloCliente): static
    {
        if ($this->TituloCliente->removeElement($tituloCliente)) {
            $tituloCliente->removeClienteTitulo($this);
        }

        return $this;
    }
}
