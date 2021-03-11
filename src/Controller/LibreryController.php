<?php


namespace App\Controller;


use App\Entity\Book;
use App\Entity\Categoria;
use App\Repository\BookRepository;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class LibreryController extends AbstractController
{

    /**
     * @Route("/books",name="book_get")
     * @param BookRepository $bookRepository
     * @param CategoriaRepository $categoriaRepository
     * @return JsonResponse
     */
    public function list(BookRepository $bookRepository){
        $books = $bookRepository->findAll();
        $booksArray = [];
        foreach ($books as $book){
            $booksArray[]=[
                'id'=>$book->getId(),
                'title'=>$book->getTitle(),
                'imagen'=>$book->getImage(),
            ];
        }
        $response = new JsonResponse();
        $response->setData([
            'success'=>true,
            'data'=> $booksArray,
        ]);
        return $response;
    }

    /**
     * @Route("/book/create",name="create_book")
     * @param Request $request
     * @param EntityManagerInterface $emi
     * @return JsonResponse
     */
    public function createBook(EntityManagerInterface $emi){
        $book = new Book('farid','12323');
        $categoria = new Categoria('carros');
        $book->setCategoria($categoria);
        $response = new JsonResponse();
        if (empty($book->getTitle())){
            $response->setData([
                'success'=>false,
                'data'=>null,
                'error'=>'title cannot by empty'
            ]);
            return $response;
        }

        $emi->persist($book);
        $emi->flush();
        $response->setData([
            'success'=>true,
            'data'=>
                [
                    'id'=>$book->getId(),
                    'title'=>$book->getTitle(),
                    'image'=>$book->getImage(),
                    'categoria'=>$book->getCategoria()
                ]

        ]);
        return $response;
    }


}