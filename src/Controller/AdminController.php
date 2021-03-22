<?php

namespace App\Controller;


use App\Repository\UserRepository;
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

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), 5
        );


        return $this->render('admin/admin.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
