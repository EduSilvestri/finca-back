<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\User\UserInterface;

class PerfilController extends AbstractController
{
    #[Route('/api/perfil', name: 'api_perfil', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function perfil(): JsonResponse
    {
        
        $user = $this->getUser();

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'nombre' => $user->getNombre(),
            'roles' => $user->getRoles(),
        ]);
    }
}
