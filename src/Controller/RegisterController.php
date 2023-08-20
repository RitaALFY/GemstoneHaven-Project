<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Form\UserType;
use App\Repository\UserRepository;

use App\service\FileUploader;
use App\service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegisterController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private TranslatorInterface $translator,
        private FileUploader $fileUploader,
        private UserService $userService
    ) { }


    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $hash): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encodez le mot de passe de l'utilisateur
            $encodedPassword = $this->userService->encodeUserPassword($user);
            $user->setPassword($encodedPassword);

            // Gérez le téléchargement et l'enregistrement de l'image de profil
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form->get('image')->getData();
            if ($uploadedFile !== null) {
                // Avant de mettre à jour l'image, nettoyez l'ancienne
                if ($user->getImage() !== null) {
                    $this->fileUploader->cleanUnusedFiles($user->getImage());
                }

                $user->setImage(
                    $this->fileUploader->uploadFile(
                        $uploadedFile,
                        '/user'
                    )
                );
            }

            // Enregistrez l'utilisateur dans la base de données
            $this->userRepository->save($user, true);

            $this->addFlash(
                'success',
                $this->translator->trans('pages.user.success_create')
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('front/pages/register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}