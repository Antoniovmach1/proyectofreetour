<?php

namespace App\Controller\Admin;

use App\Entity\Ruta;
use App\Entity\Tour;
use App\Entity\Usuario;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpParser\Builder\Use_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TourCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tour::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
       
        ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            return $action->linkToCrudAction('editTour');

        });
    }


    #[Route('/editTour', name:"editTour")]
    public function editTour(AdminContext $context)
    {
        $entityInstance = $context->getEntity()->getInstance();
        $id = $entityInstance->getId();

        return $this->render('admin/edittour.html.twig', [
           "id"=> $id
        ]);
    }


    // public function configureActions(Actions $actions): Actions
    // {
    //  return $actions
    //  ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action){
    //     return $action->linkToRoute("creatour",[]);

    //     // ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action){
    //     //     return $action->linkToRoute("nombre",[]);
    //  });
    // }


     #[Route('/creartour', name:"creatour")]
     public function home(): Response
     {

         return $this->render('admin/tour.html.twig', [
           
         ]);
       
     }

    public function configureFields(string $pageName): iterable
    {
        return [

            IdField::new('id')->hideOnForm(),
            DateTimeField::new('fecha_inicio')->setLabel('Fecha'),
            AssociationField::new('Usuario')
            ->setLabel('Nombre')
            ->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                $queryBuilder->andWhere("entity.roles like :role")
                    ->setParameter('role', "%ROLE_GUIDE%");
            })
           
        ];
    }

    
    

}
