<?php

namespace App\Controller\API;

use App\Entity\Item;
use App\Entity\Localidad;
use App\Entity\Ruta;
use App\Entity\Tour;
use App\Repository\ItemRepository;
use App\Repository\RutaRepository;
use App\Repository\TourRepository;
use App\Repository\UsuarioRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiTourController extends AbstractController
{
    
    #[Route('/tour/crear', name: 'postTour', methods: 'POST')]
    public function createTour(TourRepository $tourRepository, Request $request, EntityManagerInterface $em, UsuarioRepository $userRepository, RutaRepository $rutaRepository): Response
    {
        // Decodifica el JSON enviado en la petición en un array PHP
        $data = json_decode($request->getContent(), true);

        // Obtiene el ID y los datos de los tours del array decodificado
        $id = $data['id'];
        $tours = $data['jsonArrayProgramacion'];

        // Crea un array de mapeo que convierte las abreviaturas de días en español a las abreviaturas de días en inglés
        $dayMap = [
            'Lunes' => 'Mon',
            'Martes' => 'Tue',
            'Miércoles' => 'Wed',
            'Jueves' => 'Thu',
            'Viernes' => 'Fri',
            'Sábado' => 'Sat',
            'Domingo' => 'Sun',
        ];

        // Recorre cada tour en los datos
        foreach ($tours as $tourData) {
            // Convierte las fechas de inicio y fin en objetos DateTime
            $fecha_inicio = \DateTime::createFromFormat('d/m/Y', $tourData['temporadaIni']);
            $fecha_fin = \DateTime::createFromFormat('d/m/Y', $tourData['temporadaFin']);

            // Convierte las abreviaturas de días en español a las abreviaturas de días en inglés
            $dias = array_map(function ($dia) use ($dayMap) {
                return $dayMap[$dia];
            }, explode(',', $tourData['diasSemana']));

            // Obtiene el horario del tour y lo convierte a un objeto DateTime
            $horario = \DateTime::createFromFormat('H:i', $tourData['hora']);
            $guia = $tourData['idGuia'];

            // Crea un periodo que recorre cada día en el rango de fechas
            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod($fecha_inicio, $interval, $fecha_fin->modify('+1 day'));

            // Recorre cada día en el periodo
            foreach ($period as $date) {
                // Obtiene el día de la semana de ese día
                $dayOfWeek = $date->format('D');

                // Comprueba si ese día de la semana está en los días seleccionados
                if (in_array($dayOfWeek, $dias)) {
                    // Si el día de la semana está en los días seleccionados, crea un nuevo tour con esa fecha, el guía, la hora y el ID de la ruta
                    $tour = new Tour();



                    $tourDateTime = \DateTime::createFromFormat('H:i', $tourData['hora']);
                    $tourDateTime->setDate($date->format('Y'), $date->format('m'), $date->format('d'));
                    $tour->setFechaInicio($tourDateTime);

                    $user = $userRepository->find($guia);
                    $tour->setUsuario($user);

                    // $tour->setHora($horario);

                    $ruta = $rutaRepository->find($id);
                    $tour->setRuta($ruta);

                    // Persiste el tour en la base de datos
                    $em->persist($tour);
                }
            }
        }

        // Guarda todos los tours en la base de datos
        $em->flush();

        // Devuelve una respuesta JSON con un mensaje de éxito
        return $this->json([
            'message' => 'Tour creado con éxito'
        ], 201);
    }




    #[Route('/tour', name: 'getTour', methods:'GET')]
    public function getTour(TourRepository $tourRepository): Response
    {
  
        $tours=$tourRepository->findAll();

        if (!$tours) {
            return $this->json(['error' => 'tour no encontradas'], 404);
        }

        foreach ($tours as $tour) {
            $json[] = [
                'id' => $tour->getId(),
                'ruta_id' => $tour->getRuta()->getId(),
                'usuario_id' => $tour->getUsuario()->getId(),
               
            ];
        }

        return new JsonResponse($json, 200, [], false);
    }




    #[Route('/tour/{usuarioId}', name: 'getTourByUsuario', methods: ['GET'])]
        public function getTourByUsuario(TourRepository $tourRepository, int $usuarioId): JsonResponse
        {
            $tours = $tourRepository->findBy(['Usuario' => $usuarioId]);

            if (!$tours) {
                return $this->json(['error' => 'Tours no encontrados para el usuario con ID ' . $usuarioId], 404);
            }

            $json = [];
            foreach ($tours as $tour) {
                $json[] = [
                    'id' => $tour->getId(),
                    'fecha_inicio' => $tour->getFechaInicio(),
                    'ruta_id' => $tour->getRuta()->getId(),
                    'usuario_id' => $tour->getUsuario()->getId(),
                ];
            }

            return new JsonResponse($json, 200, [], false);
}
}





