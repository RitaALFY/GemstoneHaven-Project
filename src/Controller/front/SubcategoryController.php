<?php

namespace App\Controller\front;

use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubcategoryController extends AbstractController
{
    public function __construct(
        private SubCategoryRepository $subCategoryRepository,




)
{

}
    #[Route('/subcategory', name: 'app_subcategory')]

    public function index(): Response
    {

        return $this->render('front/pages/subcategory/index.html.twig', [
            'subCategories' => $this->subCategoryRepository->findAll(),
        ]);
    }
}
