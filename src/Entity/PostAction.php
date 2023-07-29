<?php
//
//namespace App\Controller\Api\GaleryOfUser;
//
//use App\Entity\GaleryOfUser;
//use App\Repository\NFTRepository;
//use App\Repository\UserRepository;
//use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
//
//class PostAction extends AbstractController
//{
//
//    public function handle(
//        Request                $request,
//        NFTRepository         $nftRepository,
//        UserRepository     $userRepository,
//        EntityManagerInterface $em
//    ): JsonResponse {
//        $json = json_decode($request->getContent(), true);
//
//        $nft = $nftRepository->findOneBy(['slug' => $json['nft']['slug']]);
//
//        if (!$nft) {
//            return throw new NotFoundHttpException('Le nft envoyé existe pas');
//        }
//
//        $user = $userRepository->findOneBy(['lastName' => $json['user']['lastname']]);
//
//        if (!$user) {
//            return throw new NotFoundHttpException('Le user existe pas');
//        }
//
//        $galeryOfUser = (new GaleryOfUser())
//            ->setnft($nft)
//            ->setUser($user);
//
//        $em->persist($galeryOfUser);
//        $em->flush();
//
//        return new JsonResponse(['response' => 'OK']);
//    }
//
//}
