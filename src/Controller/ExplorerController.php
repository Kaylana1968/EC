<?php

namespace App\Controller;

use App\Entity\BookReadComment;
use App\Form\BookReadCommentType;
use App\Repository\BookReadCommentRepository;
use App\Repository\BookReadLikeRepository;
use App\Repository\BookReadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExplorerController extends AbstractController
{
    private BookReadRepository $bookReadRepository;
    private BookReadCommentRepository $bookReadCommentRepository;
    private BookReadLikeRepository $bookReadLikeRepository;

    // Inject the repository via the constructor
    public function __construct(
        BookReadRepository $bookReadRepository,
        BookReadCommentRepository $bookReadCommentRepository,
        BookReadLikeRepository $bookReadLikeRepository
    ) {
        $this->bookReadRepository = $bookReadRepository;
        $this->bookReadCommentRepository = $bookReadCommentRepository;
        $this->bookReadLikeRepository = $bookReadLikeRepository;
    }

    #[Route('/explorer', name: 'app.explorer')]
    public function explorer(Request $request, EntityManagerInterface $entityManager): Response
    {
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
        }

        return $this->render('pages/explorer.html.twig', [
            'bookReads' => $bookReads,
            'comments' => $comments,
            'likes' => $likes,
            'form' => $form
        ]);
    }
}
