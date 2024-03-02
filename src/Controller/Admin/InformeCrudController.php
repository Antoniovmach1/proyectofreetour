<?php

namespace App\Controller\Admin;

use App\Entity\Informe;
use App\Entity\Ruta;
use App\Entity\Tour;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InformeCrudController extends AbstractCrudController
{
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

    
    #[Route('/informes', name: 'informesdeusuario')]
    public function verinformes(EntityManagerInterface $entityManager): Response
    {
      
        $tours = $entityManager->getRepository(Tour::class)->findAll();
        

        return $this->render('pruebas/listainforme.html.twig', [
            'tours' => $tours,
        ]);
    }


    
    #[Route('/informescalendario', name: 'informesdeusuariocalendario')]
    public function verinformescalendiario(EntityManagerInterface $entityManager): Response
    {
      
        // $tours = $entityManager->getRepository(Tour::class)->findAll();
        

        return $this->render('pruebas/listainformecalendario.html.twig', [
            // 'tours' => $tours,
        ]);
    }

}
