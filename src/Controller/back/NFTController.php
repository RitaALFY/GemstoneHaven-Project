<?php

namespace App\Controller\back;

use App\Entity\NFT;
use App\Form\NFTType;
use App\Repository\NFTRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/nft')]
class NFTController extends AbstractController
{

    #[Route('/', name: 'app_admin_n_f_t_index', methods: ['GET'])]
    public function index(NFTRepository $nFTRepository): Response
    {
        return $this->render('back/admin/pages/nft/index.html.twig', [
            'n_f_ts' => $nFTRepository->findBy([], ['dropAt' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'app_admin_n_f_t_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nFT = new NFT();
        $form = $this->createForm(NFTType::class, $nFT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nFT);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_n_f_t_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/admin/pages/nft/new.html.twig', [
            'n_f_t' => $nFT,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'app_admin_n_f_t_show', methods: ['GET'])]
    public function show(NFT $nFT): Response
    {
        return $this->render('back/admin/pages/nft/show.html.twig', [
            'n_f_t' => $nFT,
        ]);
    }

    #[Route('/{slug}/edit', name: 'app_admin_n_f_t_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NFT $nFT, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NFTType::class, $nFT);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_n_f_t_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/admin/pages/nft/edit.html.twig', [
            'n_f_t' => $nFT,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_n_f_t_delete', methods: ['POST'])]
    public function delete(Request $request, NFT $nFT, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nFT->getId(), $request->request->get('_token'))) {
            $entityManager->remove($nFT);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_n_f_t_index', [], Response::HTTP_SEE_OTHER);
    }
}
