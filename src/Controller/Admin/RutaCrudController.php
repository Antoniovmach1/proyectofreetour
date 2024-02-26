<?php

namespace App\Controller\Admin;

use App\Entity\Reserva;
use App\Entity\Ruta;
use App\Entity\Tour;
use App\Entity\Usuario;
use App\Form\ReservaType;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class RutaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ruta::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
        ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
            return $action->linkToRoute("crearuta", []);
        })
        ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            return $action->linkToCrudAction('editRedirect');

        });
    }


    #[Route('/editRedirect', name:"editRedirect")]
    public function editRedirect(AdminContext $context)
    {
        $entityInstance = $context->getEntity()->getInstance();
        $id = $entityInstance->getId();

        return $this->render('admin/ruta.html.twig', [
           "id"=> $id
        ]);
    }


    //  public function configureFields(string $pageName): iterable
    //  {
    //      return [
    //          IdField::new('id')->hideOnForm(),
    //          TextField::new('titulo'),
    //          TextField::new('descripcion'),
    //          DateTimeField::new('fecha_ini'),
    //          DateTimeField::new('fecha_fin'),
    //      ];
    //  }

    #[Route('/crearuta', name:"crearuta")]
    public function home(): Response
    {

        return $this->render('admin/ruta.html.twig', [
           
        ]);
       
    }


    #[Route('/updateruta', name:"updateruta")]
    public function updateruta(): Response
    {

        return $this->render('admin/ruta.html.twig', [
           
        ]);
       
    }

    #[Route('/rutas', name: 'rutas')]
    public function verrutas(EntityManagerInterface $entityManager): Response
    {
      
        $rutas = $entityManager->getRepository(Ruta::class)->findAll();

        return $this->render('pruebas/index.html.twig', [
            'rutas' => $rutas,
        ]);
    }

    #[Route('/rutas/{id}', name: 'rutasporid')]
    public function rutasporid(EntityManagerInterface $entityManager, $id, Request $request): Response
    {

        $reserva = new Reserva();

        $form = $this->createForm(ReservaType::class,$reserva);

        $form->handleRequest($request);

        $ruta = $entityManager->getRepository(Ruta::class)->find($id);


        

        if ($form->isSubmitted() && $form->isValid()) {

            $reserva->setUsuario($this->getUser());

            $cantidad= $form->get('cantidad')->getData();
            $reserva->setCantidad($cantidad);

            $id= $form->get('Tour')->getData();
            $tour=$entityManager->getRepository(Tour::class)->findBy(['id' => $id]);
            $reserva->setTour($tour[0]);

            $entityManager->persist($reserva);
            $entityManager->flush();
        }


    
        if (!$ruta) {
            throw $this->createNotFoundException('Ruta no encontrada con el id: ' . $id);
        }
    
        $items = $ruta->getItems();
        $tours = $ruta->getTours();
    
        // Utilizar un conjunto para asegurarse de que los usuarios no se repitan
        $usuariosSet = new ArrayCollection();
        foreach ($tours as $tour) {
            $usuariosSet->add($tour->getUsuario()->getId());
        }
    
        // Obtener los IDs de usuarios únicos como un array
        $usuariosIds = $usuariosSet->toArray();
    
        // Obtener los usuarios correspondientes a los IDs
        $usuarios = $entityManager->getRepository(Usuario::class)->findBy(['id' => $usuariosIds]);
    
        return $this->render('pruebas/ruta.html.twig', [
            'rutas' => $ruta,
            'items' => $items,
            'tours' => $tours,
            'usuarios' => $usuarios,
            'form' =>$form->createView(),
        ]);
    }
  
}