<?php

namespace App\Controller\Recruiter;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Job;
use App\Form\JobType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use App\Form\CriteriaType;

/**
 * @Route("/recruiter")
 */
class JobController extends AbstractController
{
    /**
     * @Route("/job", name="job")
     */
    public function getJobs(Request $request)
    {
        $jobs = $this->getUser()->getJobCreated();

        return $this->render('recruiter/job/index.html.twig', [
            'jobs' => $jobs
        ]);
    }

    /**
     * @Route("/job/create", name="job_create")
     */
    public function createJob(Request $request)
    {
        return $this->createOrUpdateJob($request, new Job());
    }

    /**
     * @Route("job/{id}/update", name="job_update")
     */
    public function update(Request $request, Job $job)
    {
        return $this->createOrUpdateJob($request, $job);
    }

    /**
     * @Route("/job/{id}", name="job_one")
     */
    public function one(Request $request, Job $job)
    {
        return $this->render('recruiter/job/one.html.twig', [
            'job' => $job
        ]);
    }

    /**
     * @Route("job/{id}/delete", name="job_delete")
     */
    public function remove(Request $request, Job $job)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($job);
        $em->flush();

        return $this->redirectToRoute('job');
    }

    private function createOrUpdateJob($request, Job $job)
    {
        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $job->setUser($this->getUser());
            $em->persist($job);
            $em->flush();

            return $this->redirectToRoute('job');
        }

        return $this->render('recruiter/job/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
