<?php

namespace App\Controller;

use App\Repository\BookReadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private BookReadRepository $bookReadRepository;

    // Inject the repository via the constructor
    public function __construct(BookReadRepository $bookReadRepository)
    {
        $this->bookReadRepository = $bookReadRepository;
    }

    #[Route('/', name: 'app.home')]
    public function index(): Response
    {
        $user = $this->getUser();
        $userId = $user ? $user->getId() : 1;
        $booksRead = $this->bookReadRepository->findByUserId($userId, false);

        return $this->render('pages/home.html.twig', [
            'booksRead' => $booksRead,
            'name' => 'Accueil',
        ]);
    }
}
