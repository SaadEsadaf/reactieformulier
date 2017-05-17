<?php

namespace News\CoreBundle\DataFixtures\ORM;

use News\CoreBundle\Entity\Post;
use News\CoreBundle\Entity\Author;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Fixtures for the Post Entity.
 */
class LoadPostData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $p1 = new Post;
        $p1->setTitle('Ut porta at nibh a fermentum');
        $p1->setBody('Ut porta at nibh a fermentum. Vestibulum sed velit nisi. Phasellus sit amet sodales
         lectus. Ut ut pellentesque nunc. Pellentesque luctus augue vitae semper vulputate. Aliquam rhoncus
          vel est eu dignissim. Vivamus ac rutrum dui, cursus gravida elit. Vivamus rutrum ac justo quis
           euismod. Vestibulum sit amet sem quis risus laoreet cursus vel at urna. Etiam vitae hendrerit
            nulla, fermentum aliquet leo. Vivamus placerat laoreet tristique. Integer eleifend nisi in ex
             convallis, in tristique tellus ullamcorper.');
        $p1->setAuthor($this->getAuthor($manager, 'Author 1'));

        $p2 = new Post;
        $p2->setTitle('Авпа ра апп');
        $p2->setBody('Ut porta at nibh a fermentum. Vestibulum sed velit nisi. Phasellus sit amet sodales
         lectus. Ut ut pellentesque nunc. Pellentesque luctus augue vitae semper vulputate. Aliquam rhoncus
          vel est eu dignissim. Vivamus ac rutrum dui, cursus gravida elit. Vivamus rutrum ac justo quis
           euismod. Vestibulum sit amet sem quis risus laoreet cursus vel at urna. Etiam vitae hendrerit
            nulla, fermentum aliquet leo. Vivamus placerat laoreet tristique. Integer eleifend nisi in ex
             convallis, in tristique tellus ullamcorper.');
        $p2->setAuthor($this->getAuthor($manager, 'Author 2'));

        $manager->persist($p1);
        $manager->persist($p2);
        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }

    /**
     * Gets an author.
     *
     * @param ObjectManager $manager
     * @param string $username
     *
     * @return Author
     */
    private function getAuthor(ObjectManager $manager, $username)
    {
        return $manager->getRepository('NewsCoreBundle:Author')->findOneBy(['username' => $username]);
    }
}