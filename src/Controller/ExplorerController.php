<?php

namespace App\Controller;

use App\Entity\BookReadComment;
use App\Entity\BookReadLike;
use App\Form\BookReadCommentType;
use App\Repository\BookReadCommentRepository;
use App\Repository\BookReadLikeRepository;
use App\Repository\BookReadRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExplorerController extends AbstractController
{
    private BookRepository $bookRepository;
    private BookReadRepository $bookReadRepository;
    private BookReadCommentRepository $bookReadCommentRepository;
    private BookReadLikeRepository $bookReadLikeRepository;

    // Inject the repository via the constructor
    public function __construct(
        BookRepository $bookRepository,
        BookReadRepository $bookReadRepository,
        BookReadCommentRepository $bookReadCommentRepository,
        BookReadLikeRepository $bookReadLikeRepository
    ) {
        $this->bookRepository = $bookRepository;
        $this->bookReadRepository = $bookReadRepository;
        $this->bookReadCommentRepository = $bookReadCommentRepository;
        $this->bookReadLikeRepository = $bookReadLikeRepository;
    }

    #[Route('/explorer', name: 'app.explorer')]
    public function explorer(Request $request, EntityManagerInterface $entityManager): Response
    {
        $books = $this->bookRepository->findAll();
        $bookReads = $this->bookReadRepository->findAll();
        $comments = $this->bookReadCommentRepository->findAll();
        $likes = $this->bookReadLikeRepository->findAll();

        $user = $this->getUser();

        $comment = new BookReadComment();
        $form = $this->createForm(BookReadCommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user) {
                throw new Error("Connectez-vous avant de mettre un commentaire");
            }

            $comment->setUser($user);

            $entityManager->persist($comment);
            $entityManager->flush();

            return new JsonResponse([
                'message' => "Le commentaire a bien été ajouté",
                'toAdd' => $comment->toArray()
            ]);
        }

        return $this->render('pages/explorer.html.twig', [
            'books' => $books,
            'bookReads' => $bookReads,
            'comments' => $comments,
            'likes' => $likes,
            'form' => $form
        ]);
    }

    #[Route('/add-like', name: 'api.add.like')]
    public function addLike(Request $request, EntityManagerInterface $entityManager)
    {
        $parameters = json_decode($request->getContent(), true);
        $bookReadId = $parameters['bookReadId'];

        $user = $this->getUser();

        if (!$user) {
            throw new Error("Connectez-vous avant de mettre un like");
        }

        $bookRead = $this->bookReadRepository->findOneBy([
            'id' => $bookReadId
        ]);

        $like = $this->bookReadLikeRepository->findOneBy([
            'user' => $user,
            'book_read' => $bookRead,
        ]);

        if ($like) {
            $like->setIsLiked(!$like->getIsLiked());
        } else {
            $like = new BookReadLike();

            $like->setUser($user);
            $like->setBookRead($bookRead);
            $like->setIsLiked(true);

            $entityManager->persist($like);
        }

        $entityManager->flush();

        return new JsonResponse(['message' => "Le like a bien été ajouté"]);
    }
}
