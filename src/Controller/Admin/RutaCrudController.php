<?php

namespace App\Controller\Admin;

use App\Entity\Ruta;
use DateTime;
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
    public function home2(): Response
    {

        return $this->render('admin/ruta.html.twig', [
           
        ]);
       
    }
  
}