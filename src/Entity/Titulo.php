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
    private ?string $actores_principales = null;

    #[ORM\Column(length: 2083)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?string $fecha_lanzamiento = null;

    #[ORM\Column]
    private ?int $me_gusta = null;

    #[ORM\Column(length: 255)]
    private ?array $comentario = null;

    #[ORM\Column(type : 'json')]
    private ?array $premium = null;

    #[ORM\ManyToMany(targetEntity: Cliente::class, mappedBy: 'ClienteTitulo')]
    private Collection $TituloCliente;

    #[ORM\Column(length: 2083)]
    private ?string $imagen = null;

    #[ORM\Column(length: 2083)]
    private ?string $video = null;

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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }
    public function gettip(): ?string
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


    public function getactores_principales(): ?string
    {
        return $this->actores_principales;
    }

    public function setActoresPrincipales(string $actores_principales): static
    {
        $this->actores_principales = $actores_principales;

        return $this;
    }

    public function getfecha_lanzamiento(): ?string
    {
        return $this->fecha_lanzamiento;
    }

    public function setFechaLanzamiento(string $fecha_lanzamiento): static
    {
        $this->fecha_lanzamiento = $fecha_lanzamiento;

        return $this;
    }

    public function getme_gusta(): ?int
    {
        return $this->me_gusta;
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

    public function getComentario(): ?array
    {
        return $this->comentario;
    }

    public function setComentario(array $comentario): static
    {
        $this->comentario = $comentario;

        return $this;
    }

    public function getPremium(): ?array
    {
        return $this->premium;
    }

    public function setPremium(array $premium): static
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

    public function getImagen(): ?string
    {
        return $this->imagen;
    }

    public function setImagen(string $imagen): static
    {
        $this->imagen = $imagen;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(string $video): static
    {
        $this->video = $video;

        return $this;
    }
}
