<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    /**
     * @Route("/book", name="app_book")
     */
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    /**
     * @Route("/book/create", name="create_book")
     *
     */
    public function createBook()
    {
        return $this->render('book/create.html.twig');
    }

    /**
     * @Route("/book/show", name="show")
     * methods={"POST"}
     */
    public function showLibrary(
        ManagerRegistry $doctrine,
        Request $request
    ): Response {
        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setTitle($request->request->get('title'));
        $book->setISBN($request->request->get('isbn'));
        $book->setAuthor($request->request->get('author'));
        $book->setImage($request->request->get('image_url'));

        $entityManager->persist($book);
        $entityManager->flush();

        return $this->redirectToRoute('show_all_books');
    }

    /**
     * @Route("/book/showBooks", name="show_all_books"),
     * methods={GET}
     */
    public function showBooks(
        BookRepository $bookRepository
    ): Response {

        $books = $bookRepository
            ->findAll();
        $data = [
            'books' => $books
        ];

        return $this->render('book/show.html.twig', $data);
    }

    /**
     * @Route("/book/show/{id}", name="book_by_id")
     * methods={GET}
     */
    public function showBookById(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        $data = [
            'book' => $book
        ];

        return $this->render('book/showBook.html.twig', $data);
    }

    /**
     * @Route("/book/delete/{id}", name="book_delete_by_id")
     * methods={"POST"}
     */
    public function deleteBookById(
        ManagerRegistry $doctrine,
        BookRepository $bookRepository,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $bookRepository
            ->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id ' . $id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->redirectToRoute('show_all_books');
    }

    /**
     * @Route("/book/updateBook/{id}", name="update_book")
     * methods={"GET"}
     */
    public function showUpdateBook(
        BookRepository $bookRepository,
        int $id
    ): Response {
        $book = $bookRepository
            ->find($id);

        $data = [
            'book' => $book
        ];

        return $this->render('book/update.html.twig', $data);
    }

    /**
     * @Route("/book/update/{id}", name="book_update_by_id")
     * methods={"POST"}
     */
    public function updateBook(
        ManagerRegistry $doctrine,
        BookRepository $bookRepository,
        Request $request,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $book = $bookRepository
            ->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No product found for id ' . $id
            );
        }

        $book->setTitle($request->request->get('title'));
        $book->setISBN($request->request->get('isbn'));
        $book->setAuthor($request->request->get('author'));
        $book->setImage($request->request->get('image_url'));
        $entityManager->flush();

        return $this->redirectToRoute('show_all_books');
    }
}
