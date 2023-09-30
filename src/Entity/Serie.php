<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titulo = null;

    #[ORM\Column(length: 50)]
    private ?string $genero = null;

    #[ORM\Column(length: 50)]
    private ?string $director = null;

    #[ORM\Column(length: 50)]
    private ?string $actoresPrincipales = null;

    #[ORM\Column]
    private ?int $añoLanzamiento = null;

    #[ORM\Column]
    private ?int $cantidadCapitulos = null;

    #[ORM\ManyToMany(targetEntity: Cliente::class, inversedBy: 'Serie')]
    private Collection $cliente;

    #[ORM\ManyToMany(targetEntity: Interaccion::class, mappedBy: 'serie')]
    private Collection $interaccion;

    public function __construct()
    {
        $this->cliente = new ArrayCollection();
        $this->interaccion = new ArrayCollection();
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
        return $this->actoresPrincipales;
    }

    public function setActoresPrincipales(string $actoresPrincipales): static
    {
        $this->actoresPrincipales = $actoresPrincipales;

        return $this;
    }

    public function getAñoLanzamiento(): ?int
    {
        return $this->añoLanzamiento;
    }

    public function setAñoLanzamiento(int $añoLanzamiento): static
    {
        $this->añoLanzamiento = $añoLanzamiento;

        return $this;
    }

    public function getCantidadCapitulos(): ?int
    {
        return $this->cantidadCapitulos;
    }

    public function setCantidadCapitulos(int $cantidadCapitulos): static
    {
        $this->cantidadCapitulos = $cantidadCapitulos;

        return $this;
    }

    /**
     * @return Collection<int, Cliente>
     */
    public function getCliente(): Collection
    {
        return $this->cliente;
    }

    public function addCliente(Cliente $cliente): static
    {
        if (!$this->cliente->contains($cliente)) {
            $this->cliente->add($cliente);
        }

        return $this;
    }

    public function removeCliente(Cliente $cliente): static
    {
        $this->cliente->removeElement($cliente);

        return $this;
    }

    /**
     * @return Collection<int, Interaccion>
     */
    public function getInteraccion(): Collection
    {
        return $this->interaccion;
    }

    public function addInteraccion(Interaccion $interaccion): static
    {
        if (!$this->interaccion->contains($interaccion)) {
            $this->interaccion->add($interaccion);
            $interaccion->addSerie($this);
        }

        return $this;
    }

    public function removeInteraccion(Interaccion $interaccion): static
    {
        if ($this->interaccion->removeElement($interaccion)) {
            $interaccion->removeSerie($this);
        }

        return $this;
    }
}
