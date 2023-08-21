<?php

namespace App\Controller\back;

use App\Repository\NFTRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        UserRepository $userRepository,
        NFTRepository $NFTRepository

    ): Response
    {

        return $this->render('back/admin/dashboard.html.twig', [

            'users' => $userRepository->findBy([], ['lastName' => 'DESC'], 4),
            'nfts' =>$NFTRepository->findLastAdd(),
        ]);
    }
}
