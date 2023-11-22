<?php

namespace App\Entity;

use App\Repository\TipoSuscripcionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipoSuscripcionRepository::class)]
class TipoSuscripcion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $precio = null;

    #[ORM\Column(nullable: true)]
    private ?int $mesesRestantes = null;

    #[ORM\OneToOne(mappedBy: 'TipoSuscripcion', cascade: ['persist', 'remove'])]
    private ?Cliente $clienteTipoSuscripcion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    public function getMesesRestantes(): ?int
    {
        return $this->mesesRestantes;
    }

    public function setMesesRestantes(?int $mesesRestantes): static
    {
        $this->mesesRestantes = $mesesRestantes;

        return $this;
    }

    public function getClienteTipoSuscripcion(): ?Cliente
    {
        return $this->clienteTipoSuscripcion;
    }

    public function setClienteTipoSuscripcion(?Cliente $clienteTipoSuscripcion): static
    {
        // unset the owning side of the relation if necessary
        if ($clienteTipoSuscripcion === null && $this->clienteTipoSuscripcion !== null) {
            $this->clienteTipoSuscripcion->setTipoSuscripcion(null);
        }

        // set the owning side of the relation if necessary
        if ($clienteTipoSuscripcion !== null && $clienteTipoSuscripcion->getTipoSuscripcion() !== $this) {
            $clienteTipoSuscripcion->setTipoSuscripcion($this);
        }

        $this->clienteTipoSuscripcion = $clienteTipoSuscripcion;

        return $this;
    }
}
