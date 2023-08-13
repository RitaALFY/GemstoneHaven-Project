<?php

namespace App\Controller\front;

use App\Repository\NFTRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct (
        private NFTRepository $NFTRepository,


    ) { }

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('/front/pages/home.html.twig',[
        'lastNFts' => $this->NFTRepository->findBy([], ['dropAt' => 'DESC'], 5),


    ]);
    }
    #[Route('/about', name: 'about')]
    public function about()
    {
        return $this->render('front/common/about.html.twig');
    }

}