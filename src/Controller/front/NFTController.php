<?php

namespace App\Controller\front;

use App\Entity\SubCategory;
use App\Entity\NFT;
use App\Repository\NFTRepository;
use App\Repository\SubCategoryRepository;
use Doctrine\ORM\NonUniqueResultException;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;




class NFTController extends AbstractController
{

    #[Route('/nft', name: 'app_n_f_t')]

    public function __construct(
        private NFTRepository $nftRepository,
        private SubCategoryRepository $subCategoryRepository,
        private TranslatorInterface $translator,

    ){

    }
    public function index(): Response
    {
        return $this->render('/front/pages/nft/index.html.twig',[
            'nfts' => $this->nftRepository->findAll(),


        ]);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[Route('/nft/{slug}', name: 'app_n_f_t_redirect')]
    public function handleRedirection(string $slug, Request $request): Response {
        $nft = $this->nftRepository->findFullOneBy($slug);

        if ($nft !== null) {
            return $this->show($nft, $request);
        }

        $subcategory = $this->subCategoryRepository->findOneBy(['slug' => $slug]);

        if ($subcategory !== null) {
            return $this->listBySubCategory($subcategory);
        }

        $this->addFlash(
            'danger',
            $this->translator->trans('pages.error')
        );
        return $this->redirectToRoute('app_home');
    }
    #[Route('/nft/show/{slug}', name: 'app_n_f_t_show')]
    private function show(NFT $nft, Request $request): Response
    {
        return $this->render('front/pages/nft/show.html.twig', [
            'nft' => $nft,


        ]);
    }
    private function listBySubCategory(SubCategory $subCategory): Response {
        return $this->render('front/pages/nft/list_by_subcategory.html.twig', [
            'nfts' => $this->subCategoryRepository->findBySubCategory($subCategory),
            'subcategory' => $subCategory,
        ]);
    }


}