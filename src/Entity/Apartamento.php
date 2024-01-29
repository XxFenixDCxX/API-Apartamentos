<?php

namespace App\Entity;

use App\Repository\ApartamentoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApartamentoRepository::class)]
class Apartamento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $direccion = null;

    #[ORM\Column]
    private ?float $precio = null;

    #[ORM\OneToMany(mappedBy: 'apartamento', targetEntity: Foto::class)]
    private Collection $fotos;

    #[ORM\OneToMany(mappedBy: 'apartamento', targetEntity: Reserva::class)]
    private Collection $reservas;

    public function __construct()
    {
        $this->fotos = new ArrayCollection();
        $this->reservas = new ArrayCollection();
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getDireccion(): ?string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): static
    {
        $this->direccion = $direccion;

        return $this;
    }

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): static
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * @return Collection<int, Foto>
     */
    public function getFotos(): Collection
    {
        return $this->fotos;
    }

    public function addFoto(Foto $foto): static
    {
        if (!$this->fotos->contains($foto)) {
            $this->fotos->add($foto);
            $foto->setApartamento($this);
        }

        return $this;
    }

    public function removeFoto(Foto $foto): static
    {
        if ($this->fotos->removeElement($foto)) {
            // set the owning side to null (unless already changed)
            if ($foto->getApartamento() === $this) {
                $foto->setApartamento(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Reserva>
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reserva $reserva): static
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas->add($reserva);
            $reserva->setApartamento($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): static
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getApartamento() === $this) {
                $reserva->setApartamento(null);
            }
        }

        return $this;
    }

    public function estaOcupadoEnRango(\DateTimeInterface $fechaInicio, \DateTimeInterface $fechaFin): bool
    {
        foreach ($this->reservas as $reserva) {
            if (!$reserva->isAnulada()) {
                $reservaInicio = $reserva->getFechaEntrada();
                $reservaFin = $reserva->getFechaFinContrato();

                // Verificar si hay solapamiento de fechas
                if (($fechaInicio >= $reservaInicio && $fechaInicio <= $reservaFin) ||
                    ($fechaFin >= $reservaInicio && $fechaFin <= $reservaFin) ||
                    ($fechaInicio <= $reservaInicio && $fechaFin >= $reservaFin)
                ) {
                    return true;
                }
            }
        }

        return false;
    }

    public function estaOcupado(): bool
    {
        $hoy = new \DateTime();
        foreach ($this->reservas as $reserva) {
            $fechaEntrada = $reserva->getFechaEntrada();
            $fechaFinContrato = $reserva->getFechaFinContrato();

            if ($hoy >= $fechaEntrada && $hoy <= $fechaFinContrato) {
                return true;
            }
        }

        return false;
    }

    public function toArray(): array
    {
        $fotosArray = [];

        foreach ($this->fotos as $foto) {
            $fotosArray[] = $foto->toArray();
        }

        $reservasArray = [];

        foreach ($this->reservas as $reserva) {
            $reservasArray[] = [
                'fecha_entrada' => $reserva->getFechaEntrada() ? $reserva->getFechaEntrada()->format('Y-m-d H:i:s') : null,
                'fecha_fin_contrato' => $reserva->getFechaFinContrato() ? $reserva->getFechaFinContrato()->format('Y-m-d H:i:s') : null,
            ];
        }

        return [
            'id' => $this->id,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'direccion' => $this->direccion,
            'precio' => $this->precio,
            'fotos' => $fotosArray,
            'ocupado' => $this->estaOcupado(),
            'fechas' => $reservasArray,
        ];
    }
}
