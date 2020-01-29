<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Job;
use App\Form\JobType;
use App\Repository\JobRepository;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\CriteriaType;

class JobController extends AbstractController
{
    /**
     * @Route("/job", name="view_job_list")
     */
    public function getJobs(Request $request, JobRepository $jobRepository)
    {
        return $this->render('job/index.html.twig', [
            'jobs' => $jobRepository->findAll()
        ]);
    }

    /**
     * @Route("/job/{id}", name="view_job_one")
     */
    public function one(Request $request, Job $job)
    {
        return $this->render('job/one.html.twig', [
            'job' => $job
        ]);
    }

    /**
     * @Route("/job/{id}/apply", name="job_apply")
     */
    public function apply(Request $request, Job $job)
    {
        $user = $this->getUser();
        $job->addApply($user);

        $em = $this->getDoctrine()->getManager();

        $em->persist($job);
        $em->flush();

        return $this->redirectToRoute('profile_applies');
    }
}
