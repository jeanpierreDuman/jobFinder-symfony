<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Job;
use App\Entity\Criteria;
use App\Repository\UserRepository;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class JobFixtures extends Fixture implements OrderedFixtureInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {
        $user = $this->userRepository->findOneByEmail('recruiter@recruiter.recruiter');

        $job = new Job();
        $job->setName("Développeur Web");
        $job->setType("CDD");
        $job->setDomain("Informatique");
        $job->setSubway("M12 Abbesses");
        $job->setLimitApply(5);
        $job->setConditions([
            'CV', 'MOTIVATION', 'XP', 'ETUDE'
        ]);

        $criteria1 = new Criteria();
        $criteria1->setName("CSS");
        $criteria2 = new Criteria();
        $criteria2->setName("HTML");

        $job->addCriteria($criteria1);
        $job->addCriteria($criteria2);

        $job->setDescription("Ceci est ma description");
        $job->setUser($user);
        $manager->persist($job);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}
