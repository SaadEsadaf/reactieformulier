<?php

namespace News\CoreBundle\DataFixtures\ORM;

use News\CoreBundle\Entity\Comment;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures for the Post Entity.
 */
class LoadCommentData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $posts = $manager->getRepository('NewsCoreBundle:Post')->findAll();

        foreach ($posts as $post) {
            $comment = new Comment;
            $comment->setAuthorName('Someone');
            $comment->setBody("Ut bibendum, risus ac consequat egestas, libero purus vehicula ante, ac molestie quam lacus
            tristique felis. Nullam bibendum, ipsum eget vulputate pharetra, est sem mollis dolor, non tempor
            eros lacus eget sapien. Praesent dictum quis justo non feugiat.");
            $comment->setPost($post);

            $manager->persist($comment);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }
}