<?php

namespace App\Controller\API;

use App\Entity\Item;
use App\Repository\LocalidadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiLocalidadController extends AbstractController
{


    #[Route('/localidad', name: 'getLocalidad', methods:'GET')]
    public function getLocalidad(LocalidadRepository $localidadRepository): Response
    {
        // $this->denyAccessUnlessGranted("ROLE_USER");
        $localidades=$localidadRepository->findAll();

        if (!$localidades) {
            return $this->json(['error' => 'localidades no encontradas'], 404);
        }

        foreach ($localidades as $localidad) {
            $json[] = [
                'id' => $localidad->getId(),
                'nombre' => $localidad->getNombre(),
                'provincia_id' => $localidad->getProvincia()->getId(),

            ];
        }

        return new JsonResponse($json, 200, [], false);
    }

    #[Route('/localidad/{provinciaId}', name: 'getLocalidadByProvincia', methods:'GET')]
    public function getLocalidadByProvincia(LocalidadRepository $localidadRepository, $provinciaId): Response
    {
        $localidades = $localidadRepository->findBy(['provincia' => $provinciaId]);

        if (!$localidades) {
            return $this->json(['error' => 'Localidades no encontradas para la provincia seleccionada'], 404);
        }

 
        foreach ($localidades as $localidad) {
            $json[] = [
                'id' => $localidad->getId(),
                'nombre' => $localidad->getNombre(),
                'provincia_id' => $localidad->getProvincia()->getId(),
            ];
        }

        return new JsonResponse($json, 200, [], false);
    }
}