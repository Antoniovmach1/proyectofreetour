<?php

namespace App\Controller\API;

use App\Entity\Item;
use App\Entity\Localidad;
use App\Repository\ItemRepository;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploaderService;

class ApiItemController extends AbstractController
{

    private $fileUploaderService;
    public function __construct(FileUploaderService $fileUploader) {
        $this->fileUploaderService=$fileUploader;
    }

    #[Route("/item/crear", name: "postItem", methods: ["POST"])]
    public function createItem(Request $request, EntityManagerInterface $em): JsonResponse
    {
       
        $data = $request->getContent();
            
        $titulo = $request->request->get('titulo');
        $descripcion = $request->request->get('descripcion');
        $localizacion = json_decode($request->request->get('localizacion'),true);
        $foto = $request->files->get('foto');
        $localidad = $request->request->get('localidad');


        // $titulo = $data['titulo'];
        // $descripcion = $data['descripcion'];
        // $localizacion = $data['localizacion'];

        // $foto = json_decode($data['foto']);

        // // $foto = $data['foto'] ?? null;
        // $localidadId = $data['localidad'];
    

        $nombrefoto = $this->fileUploaderService->upload($foto);
      
        if (!isset($titulo, $descripcion, $localizacion, $localidad)) {
            return $this->json(['message' => 'Faltan campos obligatorios'], 400);
        }
    
 
        $item = new Item();
        $item->setNombre($titulo);
        $item->setDescripcion($descripcion);
        $item->setLocalizacion($localizacion);
        $item->setFoto($nombrefoto);
    
      
        $localidadEntity = $em->getRepository(Localidad::class)->find($localidad);
    
        if (!$localidadEntity) {
            return $this->json(['message' => 'La localidad no existe'], 400);
        }
    

        $item->setLocalidad($localidadEntity);
    
    
        $em->persist($item);
        $em->flush();
    


        $itemId = $item->getId();


        return $this->json(['message' => 'Item creado con éxito. ID: ' . $itemId], 201);
    }

    #[Route('/item', name: 'getItem', methods:'GET')]
    public function getItem(ItemRepository $itemRepository): Response
    {
  
        $items=$itemRepository->findAll();

        if (!$items) {
            return $this->json(['error' => 'item no encontradas'], 404);
        }

        foreach ($items as $item) {
            $json[] = [
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'descripcion' => $item->getDescripcion(),
                'foto' => $item->getFoto()

            ];
        }

        return new JsonResponse($json, 200, [], false);
    }

    #[Route('/item/{localidadId}', name: 'getItemByLocalidad', methods: 'GET')]
    public function getItemByLocalidad(ItemRepository $itemRepository, $localidadId): Response
    {
        $items = $itemRepository->findBy(['Localidad' => $localidadId]);
    
        if (!$items) {
            return $this->json(['error' => 'Localidades no encontradas para la provincia seleccionada'], 404);
        }
    
        $json = [];
        foreach ($items as $item) {
            $json[] = [
                'id' => $item->getId(),
                'nombre' => $item->getNombre(),
                'descripcion' => $item->getDescripcion(),
                'provincia_id' => $item->getLocalidad()->getId(),
            ];
        }
    
        return new JsonResponse($json, 200, [], false);
    }
    
}