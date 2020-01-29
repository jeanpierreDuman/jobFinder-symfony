<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('recruiter@recruiter.recruiter');
        $user->setName('Jean-Claude Durand');
        $plainPassword = 'recruiter';
        $encoded = $this->encoder->encodePassword($user, $plainPassword);
        $user->setPassword($encoded);
        $user->setRoles(['ROLE_RECRUITER']);
        $manager->persist($user);

        $user2 = new User();
        $user2->setEmail('user@user.user');
        $user2->setName('Jean-Pierre Dupont');
        $plainPassword = 'user';
        $encoded = $this->encoder->encodePassword($user2, $plainPassword);
        $user2->setPassword($encoded);
        $user2->setRoles(['ROLE_USER']);
        $manager->persist($user2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
