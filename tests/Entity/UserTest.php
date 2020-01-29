<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\User;
use App\Entity\Criteria;
use App\Repository\UserRepository;

class UserTest extends TestCase
{
    public function checkUserCriterias()
    {
        $user = new User();
        $c1 = new Criteria();
        $c1->setName("CSS");
        $c2 = new Criteria();
        $c2->setName("Symfony");
        $user->addCriteria($c1);
        $user->addCriteria($c2);

        $this->assertEquals(2, count($user->getCriterias()));
    }
}
