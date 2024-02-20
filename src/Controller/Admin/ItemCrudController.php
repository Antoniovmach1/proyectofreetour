<?php

namespace App\Controller\Admin;

use App\Entity\Item;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }


     public function configureFields(string $pageName): iterable
     {
         return [
             IdField::new('id')->hideOnForm(),
             TextField::new('nombre'),
             TextField::new('descripcion'),
             ImageField::new('foto')
             ->setBasePath('uploads/images')
             ->setUploadDir('public/uploads/images')
             ->setUploadedFileNamePattern('[uuid].[extension]'),
             
         ];
     }


    public function configureActions(Actions $actions): Actions
    {
     return $actions
     ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action){
        return $action->linkToRoute("creaitem",[]);

        // ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action){
        //     return $action->linkToRoute("nombre",[]);
     });
    }

    #[Route('/crearitem', name:"creaitem")]
    public function home(): Response
    {

        return $this->render('admin/item.html.twig', [
           
        ]);
       
    }
  
}