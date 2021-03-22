<?php


namespace App\Controller;


use App\Entity\Book;
use App\Form\BookType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 *@IsGranted("ROLE_ADMIN")
*/
 class Formulario extends AbstractController
{
    /**
     * @Route("/admin/formulario",name="app_formularioP")
     */
    public function prueba (Request $request){

        $book = new Book();
        $form = $this->createForm(BookType::class,$book);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('book_get');
        }

        return $this->render('formulario.html.twig',array(
            'form'=>$form->createView()
        ));
    }
}