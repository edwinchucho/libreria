<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use App\Services\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_productos", methods={"GET"})
     */
    public function index(ProductRepository $repository,PaginatorInterface $paginator,Request $request)
    {
        $p = $request->query->get('p');

        $query = $repository->getSearchQuery($p);

        $products = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), 5);

        return $this->render('admin/product/show.html.twig', [
            'products' => $products,
        ]);
    }

 
    /**
     * @Route("/new", name="admin_product_new", methods={"GET","POST"})
     */
    public function new(Request $request,UploaderHelper $uploaderHelper,EntityManagerInterface $emi): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form['image']->getData();
            if ($file) {
                $newFilename = $uploaderHelper->uploadProductImage($file);
                $product->setImage($newFilename);
            }
            //------------------Image Upload--------------//
            $emi->persist($product);
            $emi->flush();

            return $this->redirectToRoute('app_admin_productos');
        }

        return $this->render('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("delete/{id}", name="admin_product_delete", methods={"DELETE"})
     */
    public function borrar($id,EntityManagerInterface $em,ProductRepository $repository)
    {
        $query = $repository->find($id);
        $em->remove($query);
        $em->flush();
        return new Response(null, 204);
    }


}
