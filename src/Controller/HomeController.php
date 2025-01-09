<?php

namespace App\Controller;

use App\Repository\BookReadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private BookReadRepository $readBookRepository;

    // Inject the repository via the constructor
    public function __construct(BookReadRepository $bookReadRepository)
    {
        $this->bookReadRepository = $bookReadRepository;
    }

    #[Route('/', name: 'app.home')]
    public function index(): Response
    {
        $userId     = 1;
        $booksRead  = $this->bookReadRepository->findByUserId($userId, false);

        return $this->render('pages/home.html.twig', [
            'booksRead' => $booksRead,
            'name'      => 'Accueil',
        ]);
    }


    #[Route('/login', name: 'auth.login')]
    public function login(): Response
    {
        var_dump("");

        return $this->render('auth/login.html.twig', [
            'name' => 'Thibaud',
        ]);
    }

    #[Route('/register', name: 'auth.register')]
    public function register(): Response
    {
        return $this->render('auth/register.html.twig', [
            'name' => 'Thibaud',
        ]);
    }
}
