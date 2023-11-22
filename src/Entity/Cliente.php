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

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $contraseña = null;

    #[ORM\Column(length: 255)]
    private ?string $correo_electronico = null;

    #[ORM\Column(length: 255)]
    private ?string $rol = null;

    #[ORM\OneToOne(inversedBy: 'clienteTipoSuscripcion', cascade: ['persist', 'remove'])]
    private ?TipoSuscripcion $TipoSuscripcion = null;

    #[ORM\ManyToOne(inversedBy: 'SuscripcionCliente')]
    private ?Suscripcion $ClienteSuscripcion = null;

    #[ORM\ManyToMany(targetEntity: Titulo::class, inversedBy: 'TituloCliente')]
    private Collection $ClienteTitulo;

    public function __construct()
    {
        $this->ClienteTitulo = new ArrayCollection();
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

    public function getCorreoElectronico(): ?string
    {
        return $this->correo_electronico;
    }

    public function setCorreoElectronico(string $correo_electronico): static
    {
        $this->correo_electronico = $correo_electronico;

        return $this;
    }

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(string $rol): static
    {
        $this->rol = $rol;

        return $this;
    }

    public function getTipoSuscripcion(): ?TipoSuscripcion
    {
        return $this->TipoSuscripcion;
    }

    public function setTipoSuscripcion(?TipoSuscripcion $TipoSuscripcion): static
    {
        $this->TipoSuscripcion = $TipoSuscripcion;

        return $this;
    }

    public function getClienteSuscripcion(): ?Suscripcion
    {
        return $this->ClienteSuscripcion;
    }

    public function setClienteSuscripcion(?Suscripcion $ClienteSuscripcion): static
    {
        $this->ClienteSuscripcion = $ClienteSuscripcion;

        return $this;
    }

    /**
     * @return Collection<int, Titulo>
     */
    public function getClienteTitulo(): Collection
    {
        return $this->ClienteTitulo;
    }

    public function addClienteTitulo(Titulo $clienteTitulo): static
    {
        if (!$this->ClienteTitulo->contains($clienteTitulo)) {
            $this->ClienteTitulo->add($clienteTitulo);
        }

        return $this;
    }

    public function removeClienteTitulo(Titulo $clienteTitulo): static
    {
        $this->ClienteTitulo->removeElement($clienteTitulo);

        return $this;
    }
}
