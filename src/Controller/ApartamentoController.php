<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Apartamento;

class ApartamentoController extends AbstractController
{
    #[Route('/apartamentos', name: 'obtener_apartamentos', methods: ['GET'])]
    public function recibirTodos(EntityManagerInterface $administradorEntidades): JsonResponse
    {
        $apartamentos = $administradorEntidades->getRepository(Apartamento::class)->findAll();

        $apartamentosArray = array_map(fn ($apartamento) => $apartamento->toArray(), $apartamentos);

        return $this->json($apartamentosArray);
    }
}
