<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Apartamento;
use App\Entity\Reserva;

class ReservasController extends AbstractController
{
    #[Route('/reservas', name: 'crear_reserva', methods: ['POST'])]
    public function crearReserva(Request $peticion, EntityManagerInterface $administradorEntidades): JsonResponse
    {
        $data = json_decode($peticion->getContent(), true);

        // Validar campos obligatorios
        if (empty($data['apartamento_id']) || empty($data['fecha_entrada']) || empty($data['fecha_fin_contrato']) || empty($data['contacto_reserva'])) {
            return $this->json(['error' => 'Todos los campos son obligatorios.'], 400);
        }

        // Obtener el apartamento
        $apartamento = $administradorEntidades->getRepository(Apartamento::class)->find($data['apartamento_id']);

        // Validar si el apartamento existe
        if (!$apartamento) {
            return $this->json(['error' => 'El apartamento no existe.'], 404);
        }

        // Convertir las fechas de entrada y fin a objetos DateTime
        $fechaEntrada = new \DateTime($data['fecha_entrada']);
        $fechaFin = new \DateTime($data['fecha_fin_contrato']);

        // Validar si el apartamento está ocupado en esas fechas
        if ($apartamento->estaOcupadoEnRango($fechaEntrada, $fechaFin)) {
            return $this->json(['error' => 'El apartamento ya está reservado en esas fechas.'], 400);
        }

        // Crear la reserva
        $reserva = new Reserva();
        $reserva->setApartamento($apartamento);
        $reserva->setFechaEntrada($fechaEntrada);
        $reserva->setFechaFinContrato($fechaFin);
        $reserva->setContactoReserva($data['contacto_reserva']);

        $administradorEntidades->persist($reserva);
        $administradorEntidades->flush();

        return $this->json(['mensaje' => 'Reserva creada correctamente.']);
    }
}
