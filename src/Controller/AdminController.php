<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\ArtworkRepository;

class AdminController extends AbstractController
{
    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'app_admin')]
    public function adminDashboard(ArtworkRepository $artworkRepository, UserRepository $userRepository): Response
    {
        $userCount = $userRepository->countUsers();

        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'artworks' => $artworkRepository->findAll(),
            'users' => $userRepository->findAll(),
            'userCount' => $userCount,


        ]);
    }
}
