<?php

namespace App\Entity;

use App\Repository\ReservaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservaRepository::class)]
class Reserva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    private ?Apartamento $apartamento = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $fecha_entrada = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $fecha_fin_contrato = null;

    #[ORM\Column(length: 255)]
    private ?string $contacto_reserva = null;

    #[ORM\Column]
    private ?bool $anulada = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getApartamento(): ?Apartamento
    {
        return $this->apartamento;
    }

    public function setApartamento(?Apartamento $apartamento): static
    {
        $this->apartamento = $apartamento;

        return $this;
    }

    public function getFechaEntrada(): ?\DateTimeInterface
    {
        return $this->fecha_entrada;
    }

    public function setFechaEntrada(\DateTimeInterface $fecha_entrada): static
    {
        $this->fecha_entrada = $fecha_entrada;

        return $this;
    }

    public function getFechaFinContrato(): ?\DateTimeInterface
    {
        return $this->fecha_fin_contrato;
    }

    public function setFechaFinContrato(\DateTimeInterface $fecha_fin_contrato): static
    {
        $this->fecha_fin_contrato = $fecha_fin_contrato;

        return $this;
    }

    public function getContactoReserva(): ?string
    {
        return $this->contacto_reserva;
    }

    public function setContactoReserva(string $contacto_reserva): static
    {
        $this->contacto_reserva = $contacto_reserva;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'apartamento' => $this->apartamento ? $this->apartamento->getId() : null,
            'fecha_entrada' => $this->fecha_entrada ? $this->fecha_entrada->format('Y-m-d H:i:s') : null,
            'fecha_fin_contrato' => $this->fecha_fin_contrato ? $this->fecha_fin_contrato->format('Y-m-d H:i:s') : null,
            'contacto_reserva' => $this->contacto_reserva,
        ];
    }

    public function isAnulada(): ?bool
    {
        return $this->anulada;
    }

    public function setAnulada(bool $anulada): static
    {
        $this->anulada = $anulada;

        return $this;
    }
}
