<?php

namespace App\Controller\User\Profile;

use App\Form\EditProfileFormType;
use App\Repository\UserRepository;
use App\Form\ChangePasswordFormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/user/home', name: 'user.home.index')]
    public function index(): Response
    {
        return $this->render('pages/user/home/index.html.twig');
    }

    #[Route('/user/profile', name: 'user.profile.index')]
    public function index_profile(): Response
    {
        return $this->render('pages/user/profile/index.html.twig');
    }

    #[Route('/user/profile/edit', name: 'user.profile.edit')]
    public function edit(Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfileFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userRepository->save($user, true);
            $this->addFlash("success", "Votre profil a été modifié !");
            return $this->redirectToRoute("user.profile.index");
        }

        return $this->render('pages/user/profile/edit.html.twig', [
            "form" => $form->createView()
        ]);
    }

    #[Route('/user/profile/edit_password', name: 'user.profile.edit_password')]
    public function editPassword(
        Request $request,
        UserRepository $userRepository, 
        UserPasswordHasherInterface $hasher,
        ): Response
    {

        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordFormType::class, null, [
            "required_current_password" => true
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $password_hashed = $hasher->hashPassword($user, $form->get('plainPassword')->getData());
            $user->setPassword($password_hashed);

            $userRepository->save($user, true);

            $this->addFlash("success", "Votre mot de passe a été changé !");
            return $this->redirectToRoute("user.profile.index");
        }

        return $this->render('pages/user/profile/edit_password.html.twig', [
            "form" => $form->createView()
        ]);
    }
}
