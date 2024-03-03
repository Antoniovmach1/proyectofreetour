<?php

namespace App\Controller\Admin;

use App\Entity\Informe;
use App\Entity\Ruta;
use App\Entity\Tour;
use App\Form\InformeFormType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploaderService;

class InformeCrudController extends AbstractCrudController
{

    private $fileUploaderService;
    public function __construct(FileUploaderService $fileUploader) {
        $this->fileUploaderService=$fileUploader;
    }


    public static function getEntityFqcn(): string
    {
        return Informe::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */

    
    // #[Route('/informes', name: 'informesdeusuario')]
    // public function verinformes(EntityManagerInterface $entityManager): Response
    // {
      
    //     $tours = $entityManager->getRepository(Tour::class)->findAll();
        

    //     return $this->render('pruebas/listainforme.html.twig', [
    //         'tours' => $tours,
    //     ]);
    // }


    
    #[Route('/informes', name: 'informesdeusuariocalendario')]
    public function verinformescalendiario(EntityManagerInterface $entityManager): Response
    {
      
       
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        return $this->render('pruebas/listainformecalendario.html.twig', [
            // 'tours' => $tours,
        ]);
    }




    

    


  
    #[Route('/informes/{id}', name: 'forminforme')]
    public function forminforme(Request $request, EntityManagerInterface $entityManager, $id): Response
    {
           // Obtener la reserva específica usando el $id proporcionado en la URL
           $tour = $entityManager->getRepository(Tour::class)->find($id);

           // Verificar si la reserva existe
           if (!$tour) {
               throw $this->createNotFoundException('No se encontró la tour con id ' . $id);
           }
   
           // Comprobar si el usuario actual es el propietario de la reserva
           $usuarioActual = $this->getUser();
           if ($usuarioActual !== $tour->getUsuario()) {
               return $this->redirectToRoute('app_login');
           }
   
           $informe = new Informe();
   
           $form = $this->createForm(InformeFormType::class, $informe);
           $form->handleRequest($request);
   
           if ($form->isSubmitted() && $form->isValid()) {
               // Manejar la carga de la foto
               $file = $form->get('foto')->getData();
            //    $file = $form->get('foto')->getData();
               if ($file) {
                //    $fileName = $fileUploader->upload($file);
     
                $fileName =$this->fileUploaderService->upload($file);
                   $informe->setFoto($fileName);
               }
     
            $observaciones = $form->get('observaciones')->getData();
            $informe->setObservaciones($observaciones);

            $recaudacion = $form->get('recaudacion')->getData();
            $informe->setRecaudacion($recaudacion);

            $presentes = $form->get('presentes')->getData();
            $informe->setPresentes($presentes);

            
 
            $informe->setTour($tour);
     
             
     
              $entityManager->persist($informe);
              $entityManager->flush();

              $this->addFlash('success', 'Informe creado con éxito.');
              return $this->redirectToRoute('forminforme', ['id' => $id]);
 
            //    return $this->redirectToRoute('reservaportour', ['id' => $id]);
 
            
          }
 
 
 
 
     
         return $this->render('pruebas/informe.html.twig', [
             'tour' => $tour,
             'form' => $form->createView(),
             
         ]);
     }
 
 

}