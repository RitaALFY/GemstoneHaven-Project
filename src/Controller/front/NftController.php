<?php

namespace App\Controller\front;

use App\Repository\NFTRepository;
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


    #[Route('/nft/disponible/{slug}', name: 'app_nft_availablebbysub')]
    public function availablebBySub(
        string $slug,
        SubCategoryRepository $subCategoryRepository
    ): Response {
        $sub = $subCategoryRepository->findOneBy(['slug' => $slug]);

        if ($sub === null) {
            $this->addFlash(
                'danger',
                $this->translator->trans('pages.error')
            );
            return $this->redirectToRoute('app_home');
        }

        $nfts = $this->NFTRepository->findBySub($sub);

        return $this->render('front/pages/nft/list_by_subcategory.html.twig', [
            'sub' => $sub,
            'nfts' => $nfts,
        ]);
    }


    #[Route('/nft/show/{slug}', name: 'app_nft_show')]
    public function show(string $slug): Response
    {
        $nft  = $this->NFTRepository->findOneBy(['slug' => $slug]);

        if (!$nft) {
            throw $this->createNotFoundException('NFT not found');
        }

        return $this->render('front/pages/nft/show.html.twig', [
            'nft' => $nft,
        ]);
}}
