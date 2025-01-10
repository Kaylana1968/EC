<?php

namespace App\Controller;

use App\Repository\BookReadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExplorerController extends AbstractController
{
    private BookReadRepository $bookReadRepository;

    // Inject the repository via the constructor
    public function __construct(BookReadRepository $bookReadRepository) {
        $this->bookReadRepository = $bookReadRepository;
    }

    #[Route('/explorer', name: 'app.explorer')]
    public function index(): Response
    {
        $bookReads = $this->bookReadRepository->findAll();

        return $this->render('pages/explorer.html.twig', [
            'bookReads' => $bookReads
        ]);
    }
}
