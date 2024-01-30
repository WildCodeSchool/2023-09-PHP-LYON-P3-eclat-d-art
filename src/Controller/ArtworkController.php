<?php

namespace App\Controller;

use App\Entity\Artwork;
use App\Entity\User;
use App\Form\ArtworkType;
use App\Repository\ArtworkRepository;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/artwork')]
class ArtworkController extends AbstractController
{
    #[Route('/', name: 'app_artwork_index', methods: ['GET'])]
    public function index(ArtworkRepository $artworkRepository): Response
    {
        return $this->render('artwork/index.html.twig', [
            'artworks' => $artworkRepository->findAllByOrderDesc(),
        ]);
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/new', name: 'app_artwork_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $artwork = new Artwork();
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artwork->setUser($this->getUser());
            $entityManager->persist($artwork);
            $entityManager->flush();

            $this->addFlash('success', 'Votre Oeuvre a bien été ajoutée');

            return $this->redirectToRoute('app_artwork_show', ['id' => $artwork->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artwork/new.html.twig', [
            'artwork' => $artwork,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_artwork_show', methods: ['GET'])]
    public function show(Artwork $artwork, ArtworkRepository $artworkRepository): Response
    {
        $user = $artwork->getUser();
        $userId = $artwork->getUser()->getId();
        $artworksUser = $artworkRepository->findImagesByUser($userId);
        return $this->render('artwork/show.html.twig', [
            'artworks' => $artworksUser,
            'artwork' => $artwork,
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_artwork_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Artwork $artwork, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() !== $artwork->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            // If not the owner, throws a 403 Access Denied exception
            throw $this->createAccessDeniedException('Only the owner can edit the program!');
        }
        $form = $this->createForm(ArtworkType::class, $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Votre Oeuvre a bien été modifiée');

            return $this->redirectToRoute('app_artwork_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('artwork/edit.html.twig', [
            'artwork' => $artwork,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_artwork_delete', methods: ['POST'])]
    public function delete(Request $request, Artwork $artwork, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser() !== $artwork->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            // If not the owner, throws a 403 Access Denied exception
            throw $this->createAccessDeniedException('Only the owner can edit the program!');
        }
        if ($this->isCsrfTokenValid('delete' . $artwork->getId(), $request->request->get('_token'))) {
            $entityManager->remove($artwork);
            $entityManager->flush();
        }
        $this->addFlash('success', 'Votre Oeuvre a bien été supprimée');

        return $this->redirectToRoute('app_artwork_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/category/{categoryName}', name: 'app_artworks_by_category', methods: ['GET'])]
    public function indexByCategory(
        ArtworkRepository $artworkRepository,
        string $categoryName,
        CategoryRepository $categoryRepository
    ): Response {
        $category = $categoryRepository->findOneBy(['name' => $categoryName]);

        $artworks = $artworkRepository->findBy(['category' => $category]);

        return $this->render('artwork/indexByCategory.html.twig', [
            'artworks' => $artworks,
            'category' => $category,
        ]);
    }
    #[Route('/search/results', name: 'search_results')]
    public function search(Request $request, ArtworkRepository $artworkRepository): Response
    {
        $query = $request->query->get('query');
        $artworks = $artworkRepository->searchByQuery($query);

        return $this->render('artwork/search/results.html.twig', [
            'artworks' => $artworks,
        ]);
    }
}
