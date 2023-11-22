<?php

namespace App\Entity;

use App\Repository\SuscripcionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SuscripcionRepository::class)]
class Suscripcion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fecha_caducidad = null;

    #[ORM\OneToMany(mappedBy: 'ClienteSuscripcion', targetEntity: Cliente::class)]
    private Collection $SuscripcionCliente;

    public function __construct()
    {
        $this->SuscripcionCliente = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaCaducidad(): ?string
    {
        return $this->fecha_caducidad;
    }

    public function setFechaCaducidad(string $fecha_caducidad): static
    {
        $this->fecha_caducidad = $fecha_caducidad;

        return $this;
    }

    /**
     * @return Collection<int, Cliente>
     */
    public function getSuscripcionCliente(): Collection
    {
        return $this->SuscripcionCliente;
    }

    public function addSuscripcionCliente(Cliente $suscripcionCliente): static
    {
        if (!$this->SuscripcionCliente->contains($suscripcionCliente)) {
            $this->SuscripcionCliente->add($suscripcionCliente);
            $suscripcionCliente->setClienteSuscripcion($this);
        }

        return $this;
    }

    public function removeSuscripcionCliente(Cliente $suscripcionCliente): static
    {
        if ($this->SuscripcionCliente->removeElement($suscripcionCliente)) {
            // set the owning side to null (unless already changed)
            if ($suscripcionCliente->getClienteSuscripcion() === $this) {
                $suscripcionCliente->setClienteSuscripcion(null);
            }
        }

        return $this;
    }

  

   
}
