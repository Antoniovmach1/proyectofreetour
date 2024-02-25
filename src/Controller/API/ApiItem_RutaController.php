<?php

namespace App\Controller\API;

use App\Entity\Item;
use App\Entity\Localidad;
use App\Entity\Ruta;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiItem_RutaController extends AbstractController
{


    // #[Route("/ruta_item/crear", name: "postItem_Ruta", methods: ["POST"])]
    // public function createItemRuta(Request $request, EntityManagerInterface $em): JsonResponse
    // {
    //     $data = json_decode($request->getContent(), true);
    
    //     $rutaId = $data['ruta_id'];
    //     $itemIds = $data['item_id'];
    
    //     if (!isset($rutaId, $itemIds) || !is_array($itemIds)) {
    //         return $this->json(['message' => 'Faltan campos obligatorios o item_id no es un array'], 400);
    //     }
    
    //     $ruta = $em->getRepository(Ruta::class)->find($rutaId);
    
    //     if (!$ruta) {
    //         return $this->json(['message' => 'No se encontró la ruta'], 404);
    //     }
    
    //     foreach ($itemIds as $itemId) {
    //         $item = $em->getRepository(Item::class)->find($itemId);
    
    //         if (!$item) {
    //             return $this->json(['message' => 'No se encontró el item con ID ' . $itemId], 404);
    //         }
    
    //         $ruta->addItem($item);
    //     }
    
    //     $em->flush();
    
    //     return $this->json(['message' => 'Relación creada con éxito. ID de ruta: ' . $rutaId], 201);
    // }
    
   
    
}