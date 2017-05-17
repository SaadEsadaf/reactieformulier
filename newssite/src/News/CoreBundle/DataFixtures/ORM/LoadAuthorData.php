<?php

namespace News\CoreBundle\DataFixtures\ORM;

use News\CoreBundle\Entity\Author;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Fixtures for the Author Entity.
 */
class LoadAuthorData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $a1 = new Author;
        $a1->setUsername('Author 1');
        $a1->setEmail('test1@example.com');
        $a1->setPassword('test1');
        $a1->setRoles(['ROLE_SUPER_ADMIN']);

        $a2 = new Author;
        $a2->setUsername('Author 2');
        $a2->setEmail('test2@example.com');
        $a2->setPassword('test2');
        $a2->setRoles(['ROLE_SUPER_ADMIN']);

        $manager->persist($a1);
        $manager->persist($a2);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}