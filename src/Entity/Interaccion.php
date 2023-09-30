<?php

namespace App\Entity;

use App\Repository\InteraccionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InteraccionRepository::class)]
class Interaccion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $meGusta = null;

    #[ORM\Column(length: 50)]
    private ?string $comentario = null;

    #[ORM\ManyToMany(targetEntity: Cliente::class, inversedBy: 'interaccion')]
    private Collection $cliente;

    #[ORM\ManyToMany(targetEntity: Serie::class, inversedBy: 'interaccion')]
    private Collection $serie;

    #[ORM\ManyToMany(targetEntity: Pelicula::class, inversedBy: 'interaccion')]
    private Collection $pelicula;

    #[ORM\ManyToMany(targetEntity: Documental::class, inversedBy: 'interaccion')]
    private Collection $Documental;

    public function __construct()
    {
        $this->cliente = new ArrayCollection();
        $this->serie = new ArrayCollection();
        $this->pelicula = new ArrayCollection();
        $this->Documental = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isMeGusta(): ?bool
    {
        return $this->meGusta;
    }

    public function setMeGusta(bool $meGusta): static
    {
        $this->meGusta = $meGusta;

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
     * @return Collection<int, Serie>
     */
    public function getSerie(): Collection
    {
        return $this->serie;
    }

    public function addSerie(Serie $serie): static
    {
        if (!$this->serie->contains($serie)) {
            $this->serie->add($serie);
        }

        return $this;
    }

    public function removeSerie(Serie $serie): static
    {
        $this->serie->removeElement($serie);

        return $this;
    }

    /**
     * @return Collection<int, Pelicula>
     */
    public function getPelicula(): Collection
    {
        return $this->pelicula;
    }

    public function addPelicula(Pelicula $pelicula): static
    {
        if (!$this->pelicula->contains($pelicula)) {
            $this->pelicula->add($pelicula);
        }

        return $this;
    }

    public function removePelicula(Pelicula $pelicula): static
    {
        $this->pelicula->removeElement($pelicula);

        return $this;
    }

    /**
     * @return Collection<int, Documental>
     */
    public function getDocumental(): Collection
    {
        return $this->documental;
    }

    public function addDocumental(Documental $documental): static
    {
        if (!$this->documental->contains($documental)) {
            $this->documental->add($documental);
        }

        return $this;
    }

    public function removeDocumental(Documental $documental): static
    {
        $this->documental->removeElement($documental);

        return $this;
    }
}
