<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\Job;
use App\Entity\User;
use App\Repository\JobRepository;

class ApplyExtension extends AbstractExtension
{
    private $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('verifyConditionApply', [$this, 'verifyConditionApply']),
            new TwigFilter('verifyLimitApply', [$this, 'verifyLimitApply']),
        ];
    }

    public function verifyLimitApply(Job $job)
    {
        if(count($job->getApplies()) >= $job->getLimitApply()) {
            return false;
        }

        return true;
    }

    public function verifyConditionApply(Job $job, User $user)
    {
        $conditions = $job->getConditions();
        $countError = 0;

        foreach($conditions as $condition) {
            switch ($condition) {
                case 'CV':
                    if($user->getCv() === null) {
                        $countError++;
                    }
                    break;
                case 'MOTIVIATION':
                    if($user->getMotivation() === null) {
                        $countError++;
                    }
                    break;
                case 'XP':
                    if(count($user->getFormations()) === 0) {
                        $countError++;
                    }
                    break;
                case 'ETUDE':
                    if(count($user->getExperiences()) === 0) {
                        $countError++;
                    }
                break;
            }
        }

        if($countError >= 1) {
            return false;
        }

        return true;
    }
}
