<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

        $query = $repository->getWithSearchQueryBuilder($q);

        $users = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), 5
        );
        return $this->render('admin/admin.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/borrar/{idEvento}", name="borrar_datos")
     */
    public function borrar($idEvento,EntityManagerInterface $em,UserRepository $repository)
    {
        $query = $repository->find($idEvento);
        $em->remove($query);
        $em->flush();

        return $this->redirectToRoute('app_admin');
    }
}
