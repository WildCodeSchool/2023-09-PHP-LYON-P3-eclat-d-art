<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ArtworkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/show/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, ArtworkRepository $artworkRepository): Response
    {
        $artworks = $artworkRepository->findBy(['user' => $user]);

        return $this->render('user/show.html.twig', [
            'user' => $user,
            'artworks' => $artworks,
        ]);
    }
}
