<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/admin/usuario", name="app_admin")
     */
    public function index(UserRepository $repository,PaginatorInterface $paginator,Request $request)
    {
        $q = $request->query->get('q');

        $query = $repository->getSearchQuery($q);

        $users = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), 5
        );
        return $this->render('admin/admin.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/borrar/{id}", name="borrar_datos")
     * @Method("DELETE")
     */
    public function borrar($id,EntityManagerInterface $em,UserRepository $repository)
    {
        $query = $repository->find($id);
        $em->remove($query);
        $em->flush();
        return new Response(null, 204);
    }
}
