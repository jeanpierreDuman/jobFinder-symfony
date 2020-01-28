<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProfileType;
use App\Service\FileUploader;

class ProfileController extends AbstractController
{
    /**
     * @Route("/profile", name="profile")
     */
    public function index()
    {
        return $this->render('profile/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/profile/edit", name="profile_edit")
     */
    public function edit(Request $request, FileUploader $fileUploader)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);
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
