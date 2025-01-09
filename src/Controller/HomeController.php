<?php

namespace App\Controller;

use App\Entity\BookRead;
use App\Form\BookReadType;
use App\Repository\BookReadRepository;
use App\Repository\BookRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    private BookReadRepository $bookReadRepository;
    private BookRepository $bookRepository;

    // Inject the repository via the constructor
    public function __construct(
        BookReadRepository $bookReadRepository,
        BookRepository $bookRepository
    ) {
        $this->bookReadRepository = $bookReadRepository;
        $this->bookRepository = $bookRepository;
    }

    #[Route('/', name: 'app.home')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // get connected user
        $user = $this->getUser();
        $booksReads = $user ? $this->bookReadRepository->findByUser($user, false) : [];

        // get all books
        $books = $this->bookRepository->findAll();

        $bookRead = new BookRead();
        $form = $this->createForm(BookReadType::class, $bookRead, [
            'books' => $books
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user) {
                throw new Error("Connectez-vous avant de mettre un avis");
            }

            $bookRead->setRead($form->get('is_read')->getData());
            $bookRead->setUpdatedAt(new DateTime()); // update updated_at
            $bookRead->setUser($user); // update user

            $entityManager->persist($bookRead);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse(['message' => "L'avis a bien été pris en compte"]);
            }

            return $this->render('pages/home.html.twig', [
                'form' => $form,
                'booksReads' => $booksReads,
                'books' => $books,
                'name' => 'Accueil',
            ]);
        }

        return $this->render('pages/home.html.twig', [
            'form' => $form,
            'booksReads' => $booksReads,
            'books' => $books,
            'name' => 'Accueil',
        ]);
    }
}
