<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProfileType;
use App\Service\FileUploader;
use App\Entity\User;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile")
     */
    public function index()
    {
        return $this->render('user/profile/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/user/{id}", name="show_user_profile")
     */
    public function showUserProfile(User $user)
    {
        return $this->render('user/profile/user_index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/applies", name="profile_applies")
     */
    public function showUserApplies()
    {
        return $this->render('user/profile/applies.html.twig');
    }

    /**
     * @Route("/cv/show", name="profile_cv_show")
     */
    public function showCvPDF(Request $request, FileUploader $fileUploader)
    {
        $path = $request->query->get('path');

        if($path === null) {
            $path = $this->getUser()->getCv();
        }

        return $fileUploader->showFile($this->getParameter('cv_directory') . '/' . $path);
    }

    /**
     * @Route("/motivation/show", name="profile_motivation_show")
     */
    public function showMotivationPDF(Request $request, FileUploader $fileUploader)
    {
        $path = $request->query->get('path');

        if($path === null) {
            $path = $this->getUser()->getMotivation();
        }

        return $fileUploader->showFile($this->getParameter('motivation_directory') . '/' . $path);
    }

    /**
     * @Route("/edit", name="profile_edit")
     */
    public function edit(Request $request, FileUploader $fileUploader)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user, [
            'roles' => $user->getRoles()
        ]);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $profileFiles = $request->files->get('profile');

            $user = $fileUploader->uploadMultiple($user, [
                'cv' => $profileFiles['cv'],
                'motivation' => $profileFiles['motivation']
            ]);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('user/profile/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
