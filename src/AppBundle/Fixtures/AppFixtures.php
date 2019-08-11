<?php

namespace AppBundle\Fixtures;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use AppBundle\Constants;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $em)
    {
        $user = new User();
        $user->setUsername('user');
        $user->setPlainPassword('1234');
        $user->addRole("ROLE_ADMIN");
        $user->setEnabled(true);

        $em->persist($user);
        $em->flush();
    }
}
