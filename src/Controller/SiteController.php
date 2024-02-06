<?php

// src/Controller/SiteController.php
namespace App\Controller;

use App\Service\SiteUpdateManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// ...

class SiteController extends AbstractController
{
    #[Route('/pruebaenvio', name: 'pruebaenvio')]
    public function new(SiteUpdateManager $siteUpdateManager): Response
    {
        // ...

        if ($siteUpdateManager->notifyOfSiteUpdate()) {
            $this->addFlash('success', 'Notification mail was sent successfully.');
        }

        // Return a Response object
        return $this->render('pruebas/index.html.twig', [
            // ... your template variables
        ]);
    }


    #[Route('/', name:"home")]
    public function home(): Response
    {



        return $this->render('home.html.twig', [
           
        ]);
       
    }
}
