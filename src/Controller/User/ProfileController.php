<?php

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProfileType;
use App\Service\FileUploader;

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
        return $this->render('profile/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/cv/show", name="profile_cv_show")
     */
    public function showCvPDF(Request $request, FileUploader $fileUploader)
    {
        return $fileUploader->showFile($this->getParameter('cv_directory') . '/' . $this->getUser()->getCv());
    }

    /**
     * @Route("/motivation/show", name="profile_motivation_show")
     */
    public function showMotivationPDF(Request $request, FileUploader $fileUploader)
    {
        return $fileUploader->showFile($this->getParameter('motivation_directory') . '/' . $this->getUser()->getMotivation());
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

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
