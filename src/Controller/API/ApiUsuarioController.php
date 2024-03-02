<?php

namespace App\Controller\API;

use App\Entity\Usuario;
use App\Repository\ProvinciaRepository;
use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiUsuarioController extends AbstractController
{
    #[Route('/guia', name: 'getGuia', methods:'GET')]
    public function getUsuario(UsuarioRepository $usuarioRepository): Response
    {

        if ($this->estalogeado()){

       

        $usuarios=$usuarioRepository->findAll();
       

        if (!$usuarios) {
            return $this->json(['error' => 'usuarios no encontrados'], 404);
        }

        foreach ($usuarios as $usuario) {
            if (in_array("ROLE_GUIDE", $usuario->getRoles())) {
            
          
            $json[] = [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'apellidos' => $usuario->getApellidos(),
                'rol' => $usuario->getRoles()

            ];
        }
        }

        return new JsonResponse($json, 200, [], false);
    }else{
        return $this->json(['error' => 'Debe iniciar sesion'], 401);
    }
    }


private function estalogeado():bool
{
    if ($this->getUser()){
    
    return true;
}
return false;
}
}