<?php

namespace App\Controller\API;

use App\Repository\ProvinciaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiProvinciaController extends AbstractController
{
    #[Route('/provincia', name: 'getProvincia', methods:'GET')]
    public function getProvincia(ProvinciaRepository $provinciaRepository): Response
    {
        // $this->denyAccessUnlessGranted("ROLE_USER");
        $provincias=$provinciaRepository->findAll();

        if (!$provincias) {
            return $this->json(['error' => 'provincias no encontradas'], 404);
        }

        foreach ($provincias as $provincia) {
            $json[] = [
                'id' => $provincia->getId(),
                'nombre' => $provincia->getNombre()

            ];
        }

        return new JsonResponse($json, 200, [], false);
    }
}