<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClienteRepository::class)]
class Cliente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 50)]
    private ?string $contraseña = null;

    #[ORM\Column(length: 50)]
    private ?string $correo = null;

    #[ORM\Column]
    private ?bool $suscripcion = null;

    #[ORM\ManyToMany(targetEntity: Serie::class, mappedBy: 'cliente')]
    private Collection $Serie;

    #[ORM\ManyToMany(targetEntity: Pelicula::class, mappedBy: 'cliente')]
    private Collection $pelicula;

    #[ORM\ManyToMany(targetEntity: Documental::class, mappedBy: 'cliente')]
    private Collection $documental;

    #[ORM\ManyToMany(targetEntity: Interaccion::class, mappedBy: 'cliente')]
    private Collection $interaccion;

    public function __construct()
    {
        $this->Serie = new ArrayCollection();
        $this->pelicula = new ArrayCollection();
        $this->documental = new ArrayCollection();
        $this->interaccion = new ArrayCollection();
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

    public function getContraseña(): ?string
    {
        return $this->contraseña;
    }

    public function setContraseña(string $contraseña): static
    {
        $this->contraseña = $contraseña;

        return $this;
    }

    public function getCorreo(): ?string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): static
    {
        $this->correo = $correo;

        return $this;
    }

    public function isSuscripcion(): ?bool
    {
        return $this->suscripcion;
    }

    public function setSuscripcion(bool $suscripcion): static
    {
        $this->suscripcion = $suscripcion;

        return $this;
    }

    /**
     * @return Collection<int, Serie>
     */
    public function getSerie(): Collection
    {
        return $this->Serie;
    }

    public function addSerie(Serie $serie): static
    {
        if (!$this->Serie->contains($serie)) {
            $this->Serie->add($serie);
            $serie->addCliente($this);
        }

        return $this;
    }

    public function removeSerie(Serie $serie): static
    {
        if ($this->Serie->removeElement($serie)) {
            $serie->removeCliente($this);
        }

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
            $pelicula->addCliente($this);
        }

        return $this;
    }

    public function removePelicula(Pelicula $pelicula): static
    {
        if ($this->pelicula->removeElement($pelicula)) {
            $pelicula->removeCliente($this);
        }

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
            $documental->addCliente($this);
        }

        return $this;
    }

    public function removeDocumental(Documental $documental): static
    {
        if ($this->documental->removeElement($documental)) {
            $documental->removeCliente($this);
        }

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
            $interaccion->addCliente($this);
        }

        return $this;
    }

    public function removeInteraccion(Interaccion $interaccion): static
    {
        if ($this->interaccion->removeElement($interaccion)) {
            $interaccion->removeCliente($this);
        }

        return $this;
    }
}
