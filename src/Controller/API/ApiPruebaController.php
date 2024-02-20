<?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\HttpFoundation\Request;
// use Doctrine\DBAL\Driver\Connection;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Component\Routing\Annotation\Route;

// class ApiPruebaController extends AbstractController
// {
//     private $connection;

//     public function __construct(Connection $connection)
//     {
//         $this->connection = $connection;
//     }

//     #[Route("/rutaytour/crear", name: "postRutayTour", methods: ["POST"])]
//     public function createRutayTour(Request $request, EntityManagerInterface $em): JsonResponse
//     {
//        // Puedes obtener parámetros de la solicitud POST utilizando el objeto Request
//        $startDate = $request->request->get('start_date', '2024-01-16');
//        $endDate = $request->request->get('end_date', '2024-02-21');
    
//        $query = $em->createQuery("
//            SELECT DATE_FORMAT(fecha, '%Y-%m-%d') AS fecha_formateada, DAYNAME(fecha) AS nombre_dia_semana
//            FROM (
//                SELECT '{$startDate}' + INTERVAL n DAY AS fecha
//                FROM (
//                    SELECT @n := @n + 1 AS n
//                    FROM (
//                        SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
//                    ) a,
//                    (
//                        SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
//                    ) b,
//                    (
//                        SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
//                    ) c,
//                    (
//                        SELECT 0 UNION ALL SELECT 1 UNION ALL SELECT 2 UNION ALL SELECT 3
//                    ) d,
//                    (
//                        SELECT @n := -1
//                    ) num
//                ) numbers
//                WHERE n <= DATEDIFF('{$endDate}', '{$startDate}')
//            ) d
//            WHERE DAYOFWEEK(fecha) IN (1, 2, 3, 4, 5, 6, 7)
//        ");
    
//        $result = $query->getResult();
    
//        $formattedResult = [];
//        foreach ($result as $row) {
//            $formattedResult[] = [
//                'fecha_formateada' => $row['fecha_formateada'],
//                'nombre_dia_semana' => $row['nombre_dia_semana'],
//            ];
//        }
    
//        return $this->json($formattedResult);
//     }
// }