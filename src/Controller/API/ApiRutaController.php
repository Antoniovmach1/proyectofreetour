<?php

namespace App\Controller\API;

use App\Entity\Item;
use App\Entity\Localidad;
use App\Entity\Ruta;
use App\Repository\ItemRepository;
use App\Repository\RutaRepository;
use App\Service\FileUploaderService;
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

    private $fileUploaderService;
    public function __construct(FileUploaderService $fileUploader) {
        $this->fileUploaderService=$fileUploader;
    }

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
    //         //$fecha_ini = new DateTime($data['fecha_ini']);
    //         // $fecha_fin = new DateTime($data['fecha_fin']);

    //     $aforo = $data['aforo'];
    //     $programacion = $data['programacion'];

    //     if (!isset($titulo, $descripcion, $punto_inicio, $fecha_ini, $fecha_fin, $aforo)) {
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

    //     // ------------

    //     $listaItems = $data['listaItems'];
        

    //     if (!isset($rutaId, $listaItems) || !is_array($listaItems)) {
    //         return $this->json(['message' => 'Faltan campos obligatorios o item_id no es un array'], 400);
    //     }

       

       

    //     $ruta = $em->getRepository(Ruta::class)->find($rutaId);

    //     if (!$ruta) {
    //         return $this->json(['message' => 'No se encontró la ruta'], 404);
    //     }

    //     foreach ($listaItems as $itemId) {
    //         $item = $em->getRepository(Item::class)->find($itemId);

    //         if (!$item) {
    //             return $this->json(['message' => 'No se encontró el item con ID ' . $itemId], 404);
    //         }

    //         $ruta->addItem($item);
    //     }

    //     $em->flush();

    //     return $this->json(['message' => $rutaId], 201);
    // }


//-----
#[Route("/ruta/crear", name: "postRuta", methods: ["POST"])]
public function createRuta(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = $request->getContent();

    $titulo = $request->request->get('titulo');
    $descripcion = $request->request->get('descripcion');
    $foto = $request->files->get('foto');

    $punto_inicio = json_decode($request->request->get('punto_inicio'),true);

    // Obtener valores de fechas del formulario

    $fechaIniString = $request->request->get('fecha_ini');
    $fechaFinString = $request->request->get('fecha_fin');
    
    // Convertir las cadenas a objetos DateTime con el formato esperado
    $fecha_ini = DateTime::createFromFormat('d/m/Y', $fechaIniString);
    $fecha_fin = DateTime::createFromFormat('d/m/Y', $fechaFinString);

    
        //$fecha_ini = new DateTime($data['fecha_ini']);
        // $fecha_fin = new DateTime($data['fecha_fin']);


    $aforo = $request->request->get('aforo');

    $programacion = json_decode($request->request->get('programacion'), true);



    $nombrefoto = $this->fileUploaderService->upload($foto);

     if (!isset($titulo, $descripcion, $punto_inicio, $fecha_ini, $fecha_fin, $aforo)) {
         return $this->json(['message' => 'Faltan campos obligatorios'], 400);
     }

    $ruta = new Ruta();
    $ruta->setTitulo($titulo);
    $ruta->setDescripcion($descripcion);
    $ruta->setFoto($nombrefoto);
    $ruta->setPuntoInicio($punto_inicio);
    $ruta->setFechaIni($fecha_ini);
    $ruta->setFechaFin($fecha_fin);
    $ruta->setAforo($aforo);
    $ruta->setProgramacion($programacion);

    
    $em->persist($ruta);
    $em->flush();


//     // Obtiene el ID de la nueva ruta
//     $rutaId = $ruta->getId();
//     $listaItems = $request->request->get('listaItems');
   
//     if (!isset($rutaId) ) {
//         return $this->json(['message' => 'joder'], 400);
//     }

//     // Verifica la existencia de los campos necesarios y su formato
//     if (!isset($listaItems) || !is_array($listaItems)) {
//         return $this->json(['message' => 'Faltan campos obligatorios o item_id no es un array'.$rutaId." ".$listaItems], 400);
//     }

//   // Encuentra la ruta recién creada por su ID
//   $ruta = $em->getRepository(Ruta::class)->find($rutaId);

//   if (!$ruta) {
//       return $this->json(['message' => 'No se encontró la ruta'], 404);
//   }

//   // Agrega los items a la ruta
//   foreach ($listaItems as $itemId) {
//       $item = $em->getRepository(Item::class)->find($itemId);

//       if (!$item) {
//           return $this->json(['message' => 'No se encontró el item con ID ' . $itemId], 404);
//       }

//       $ruta->addItem($item);
//   }

//   // Guarda los cambios en la base de datos
//   $em->flush();
$rutaId = $ruta->getId();

  return $this->json(['message' => $rutaId ], 201);
}

//----

#[Route("/ruta_item/crear", name: "postRuta_item", methods: ["POST"])]
public function createRuta_Item(Request $request, EntityManagerInterface $em): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $id = $data['id'];
    $listaItems = $data['listaItems'];

    if (!isset($id, $listaItems) || !is_array($listaItems)) {
        return $this->json(['message' => 'Faltan campos obligatorios '], 400);
    }

   

    $em->flush();

    $ruta = $em->getRepository(Ruta::class)->find($id);

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

    return $this->json(['message' => $id], 201);
}













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

    return $this->json(['message' => $rutaId], 201);
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




    #[Route('/ruta/{id}', name: 'getRutaById', methods:'GET')]
    public function getRutaById(int $id, RutaRepository $rutaRepository): Response
    {
        $ruta = $rutaRepository->find($id);

        if (!$ruta) {
            return $this->json(['error' => 'Ruta not found'], 404);
        }

        $json = [
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

        return new JsonResponse($json, 200, [], false);
    }
}