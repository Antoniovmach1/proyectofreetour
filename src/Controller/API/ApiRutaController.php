<?php

namespace App\Controller\API;

use App\Entity\Item;
use App\Entity\Localidad;
use App\Entity\Ruta;
use App\Repository\ItemRepository;
use App\Repository\RutaRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiRutaController extends AbstractController
{


    // #[Route("/ruta/crear", name: "postRuta", methods: ["POST"])]
    // public function createRuta(Request $request, EntityManagerInterface $em): JsonResponse
    // {
       
    //     $data = json_decode($request->getContent(), true);
    
 
    //     $titulo = $data['titulo'];
    //     $descripcion = $data['descripcion'];
    //     $foto = $data['foto'] ?? null;
    //     $punto_inicio = $data['punto_inicio'];
    //     $fecha_ini = new DateTime($request->request->get('fecha_ini'));
    //     $fecha_fin = new DateTime($request->request->get('fecha_fin'));
    //     // $fecha_ini = new DateTime($data['fecha_ini']);
    //     // $fecha_fin = new DateTime($data['fecha_fin']);
    //     $aforo = $data['aforo'];
    //     $programacion = $data['programacion'];
      
    //     if (!isset($titulo, $descripcion,$punto_inicio,$fecha_ini,$fecha_fin,$aforo)) {
    //         return $this->json(['message' => 'Faltan campos obligatorios'], 400);
    //     }
    
 
    //     $ruta = new Ruta();
    //     $ruta->setTitulo($titulo);
    //     $ruta->setDescripcion($descripcion);
    //     $ruta->setFoto($foto);
    //     $ruta->setPuntoInicio($punto_inicio);
    //     $ruta->setFechaIni($fecha_ini);
    //     $ruta->setFechaFin($fecha_fin);
    //     $ruta->setAforo($aforo);
    //     $ruta->setProgramacion($programacion);
    
      
     
    
    
    //     $em->persist($ruta);
    //     $em->flush();
    


    //     $rutaId = $ruta->getId();


    //     return $this->json(['message' => 'Ruta creada con éxito. ID: ' . $rutaId], 201);
    // }



    #[Route("/ruta/crear", name: "postRuta", methods: ["POST"])]
    public function createRuta(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $titulo = $data['titulo'];
        $descripcion = $data['descripcion'];
        $foto = $data['foto'] ?? null;
        $punto_inicio = $data['punto_inicio'];
        $fecha_ini = new DateTime($request->request->get('fecha_ini'));
        $fecha_fin = new DateTime($request->request->get('fecha_fin'));
            //$fecha_ini = new DateTime($data['fecha_ini']);
            // $fecha_fin = new DateTime($data['fecha_fin']);

        $aforo = $data['aforo'];
        $programacion = $data['programacion'];

        if (!isset($titulo, $descripcion, $punto_inicio, $fecha_ini, $fecha_fin, $aforo)) {
            return $this->json(['message' => 'Faltan campos obligatorios'], 400);
        }

        $ruta = new Ruta();
        $ruta->setTitulo($titulo);
        $ruta->setDescripcion($descripcion);
        $ruta->setFoto($foto);
        $ruta->setPuntoInicio($punto_inicio);
        $ruta->setFechaIni($fecha_ini);
        $ruta->setFechaFin($fecha_fin);
        $ruta->setAforo($aforo);
        $ruta->setProgramacion($programacion);

        
        $em->persist($ruta);
        $em->flush();

        $rutaId = $ruta->getId();

        // ------------

        $listaItems = $data['listaItems'];
        

        if (!isset($rutaId, $listaItems) || !is_array($listaItems)) {
            return $this->json(['message' => 'Faltan campos obligatorios o item_id no es un array'], 400);
        }

       

       

        $ruta = $em->getRepository(Ruta::class)->find($rutaId);

        if (!$ruta) {
            return $this->json(['message' => 'No se encontró la ruta'], 404);
        }

        foreach ($listaItems as $itemId) {
            $item = $em->getRepository(Item::class)->find($itemId);

            if (!$item) {
                return $this->json(['message' => 'No se encontró el item con ID ' . $itemId], 404);
            }

            $ruta->addItem($item);
        }

        $em->flush();

        return $this->json(['message' => $rutaId], 201);
    }


//-----


//----

#[Route("/ruta_tour/crear", name: "postRuta_Tour", methods: ["POST"])]
public function createRuta_Tour(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $titulo = $data['titulo'];
    $descripcion = $data['descripcion'];
    $foto = $data['foto'] ?? null;
    $punto_inicio = $data['punto_inicio'];
    $fecha_ini = new DateTime($request->request->get('fecha_ini'));
    $fecha_fin = new DateTime($request->request->get('fecha_fin'));
    $aforo = $data['aforo'];
    $programacion = $data['programacion'];

    if (!isset($titulo, $descripcion, $punto_inicio, $fecha_ini, $fecha_fin, $aforo)) {
        return $this->json(['message' => 'Faltan campos obligatorios'], 400);
    }

    $ruta = new Ruta();
    $ruta->setTitulo($titulo);
    $ruta->setDescripcion($descripcion);
    $ruta->setFoto($foto);
    $ruta->setPuntoInicio($punto_inicio);
    $ruta->setFechaIni($fecha_ini);
    $ruta->setFechaFin($fecha_fin);
    $ruta->setAforo($aforo);
    $ruta->setProgramacion($programacion);

    
    $em->persist($ruta);
    $em->flush();

    $rutaId = $ruta->getId();

    // ------------

    $listaItems = $data['listaItems'];
    

    if (!isset($rutaId, $listaItems) || !is_array($listaItems)) {
        return $this->json(['message' => 'Faltan campos obligatorios o item_id no es un array'], 400);
    }

   

    $em->flush();

    $ruta = $em->getRepository(Ruta::class)->find($rutaId);

    if (!$ruta) {
        return $this->json(['message' => 'No se encontró la ruta'], 404);
    }

    foreach ($listaItems as $itemId) {
        $item = $em->getRepository(Item::class)->find($itemId);

        if (!$item) {
            return $this->json(['message' => 'No se encontró el item con ID ' . $itemId], 404);
        }

        $ruta->addItem($item);
    }

    $em->flush();

    return $this->json(['message' => 'Relación creada con éxito. ID de ruta: ' . $rutaId], 201);
}


//------




//-----


    #[Route('/ruta', name: 'getRuta', methods:'GET')]
    public function getRuta(RutaRepository $rutaRepository): Response
    {
  
        $rutas=$rutaRepository->findAll();

        if (!$rutas) {
            return $this->json(['error' => 'ruta no encontradas'], 404);
        }

        foreach ($rutas as $ruta) {
            $json[] = [
                'id' => $ruta->getId(),
                'titulo' => $ruta->getTitulo(),
                'descripcion' => $ruta->getDescripcion(),
                'foto' => $ruta->getFoto(),
                'punto_inicio' => $ruta->getPuntoInicio(),
                'fecha_ini' => $ruta->getFechaIni(),
                'fecha_fin' => $ruta->getFechaFin(),
                'aforo' => $ruta->getAforo(),
                'programacion' => $ruta->getProgramacion(),

            ];
        }

        return new JsonResponse($json, 200, [], false);
    }
}