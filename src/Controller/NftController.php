<?php

namespace App\Controller;

use App\Repository\NFTRepository;
use App\Entity\NFT;
use App\Repository\SubCategoryRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


class NftController extends AbstractController
{
    public function __construct(
        private NFTRepository $NFTRepository,
        private SubCategoryRepository $subCategoryRepository,
        private TranslatorInterface $translator,

    )
    {}

    #[Route('/nft', name: 'app_nft')]
    public function index(): Response
    {
        return $this->render('front/pages/nft/index.html.twig', [
            'controller_name' => 'NftController',
            'nfts' => $this->NFTRepository->findAll(),
        ]);
    }

    #[Route('/nft/show/{slug}', name: 'app_nft_show')]
    public function show(string $slug): Response
    {
        $nft = $this->NFTRepository->findFullOneBy(['slug' => $slug]);

        if (!$nft) {
            throw $this->createNotFoundException('NFT not found');
        }

        return $this->render('front/pages/nft/show.html.twig', [
            'nft' => $nft,
        ]);
    }
}
