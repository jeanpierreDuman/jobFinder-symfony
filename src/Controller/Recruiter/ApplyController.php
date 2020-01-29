<?php

namespace App\Controller\Recruiter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Job;

/**
 * @Route("/recruiter")
 */
class ApplyController extends AbstractController
{
    /**
     * @Route("/job/{id}/applies", name="recruiter_show_applies")
     */
    public function showApplies(Request $request, Job $job)
    {
        return $this->render('recruiter/apply/index.html.twig', [
            'job' => $job
        ]);
    }
}
