<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ArtworkRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', methods: ['GET'])]
    public function index(
        ArtworkRepository $artworkRepository,
        UserRepository $userRepository
    ): Response {

        $artworks = $artworkRepository->findRandomImages();
        $users = $userRepository->findAll();
        $user = $this->getUser();

        shuffle($users);

        $selectedUsers = array_slice($users, 0, 6);

        if ($this->getUser()) {
            $this->addFlash('success', 'Heureux de vous revoir');
        }
        return $this->render('home/index.html.twig', [
            'artworks' => $artworks,
            'users' => $selectedUsers,
            'user' => $user,
        ]);
    }
}
