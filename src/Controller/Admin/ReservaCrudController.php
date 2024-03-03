<?php

namespace App\Controller\Admin;

use App\Entity\Reserva;
use App\Entity\Ruta;
use App\Entity\Tour;
use App\Entity\Usuario;
use App\Entity\Valoracion;
use App\Form\ReservaDeleteType;
use App\Form\ReservaType;
use App\Form\ValoracionType;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reserva::class;
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

    #[Route('/reservas', name: 'reservasdeusuario')]
    public function verreservas(EntityManagerInterface $entityManager): Response
    {
      
        $reservas = $entityManager->getRepository(Reserva::class)->findAll();
        

        return $this->render('pruebas/listareserva.html.twig', [
            'reservas' => $reservas,
        ]);
    }





    // #[Route('/reservas/{id}', name: 'reservasporid')]
    // public function verreservasporid(EntityManagerInterface $entityManager, $id, Request $request): Response
    // {
    //     $reservas = $entityManager->getRepository(Reserva::class)->findAll();
        

    //     $valoracion = new Valoracion();
        
    //     $form = $this->createForm(ValoracionType::class, $valoracion);
        
    //     $form->handleRequest($request);
    

    
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         // $valoracion->setUsuario($this->getUser());
    
    //         // Obtener los valores del formulario
    //         $valoracion_guia = $form->get('valoracion_guia')->getData();
    //         $valoracion->setValoracionGuia($valoracion_guia);
    
    //         $valoracion_ruta = $form->get('valoracion_Ruta')->getData();
    //         $valoracion->setValoracionRuta($valoracion_ruta);
    
    //         $comentario = $form->get('comentario')->getData();
    //         $valoracion->setComentario($comentario);
    
       
    
    //         $entityManager->persist($valoracion);
    //         $entityManager->flush();
    //     }
    
    //     return $this->render('pruebas/reservaindividual.html.twig', [
    //         'reservas' => $reservas,
    //         'form' => $form->createView(),
    //     ]);
    // }






    #[Route('/reservas/{id}', name: 'reservaportour')]
    public function rutasporid(EntityManagerInterface $entityManager, $id, Request $request): Response
    {
        // Obtener la reserva específica usando el $id proporcionado en la URL
        $reserva = $entityManager->getRepository(Reserva::class)->find($id);
       
    
        // Verificar si la reserva existe
        if (!$reserva) {
            throw $this->createNotFoundException('No se encontró la reserva con id ' . $id);
        }
    

          // Comprobar si el usuario actual es el propietario de la reserva
    $usuarioActual = $this->getUser();

    if ($usuarioActual !== $reserva->getUsuario()) {
        return $this->redirectToRoute('app_login');
    }
    
        // Crear una nueva instancia de Valoracion y establecer la reserva
        $valoracion = new Valoracion();
      
    
        $form = $this->createForm(ValoracionType::class, $valoracion);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
       
            
            $valoracion_guia = $form->get('valoracion_guia')->getData();
            $valoracion->setValoracionGuia($valoracion_guia);
    
            $valoracion_ruta = $form->get('valoracion_Ruta')->getData();
            $valoracion->setValoracionRuta($valoracion_ruta);
    
            $comentario = $form->get('comentario')->getData();
            $valoracion->setComentario($comentario);

            $valoracion->setReserva($reserva);
    
            
    
            $entityManager->persist($valoracion);
            $entityManager->flush();

            return $this->redirectToRoute('reservaportour', ['id' => $id]);

           
        }




    
        return $this->render('pruebas/reservaindvprueba.html.twig', [
            'reserva' => $reserva,
            'form' => $form->createView(),
            
        ]);
    }


    #[Route('/reservas/{id}/delete', name: 'deletereserva')]
    public function eliminarReserva(EntityManagerInterface $entityManager, $id): Response
{
  
    $reserva = $entityManager->getRepository(Reserva::class)->find($id);


  
    if (!$reserva) {
        throw $this->createNotFoundException('No se encontró la reserva con id ' . $id);
    }

    

   
    $usuarioActual = $this->getUser();
    if ($usuarioActual !== $reserva->getUsuario()) {
        return $this->redirectToRoute('app_login');
    }

    foreach ($reserva->getValoracions() as $valoracion) {
        $entityManager->remove($valoracion);
    }

 
    $entityManager->remove($reserva);
    $entityManager->flush();


    return $this->redirectToRoute('reservasdeusuario');
}

}
