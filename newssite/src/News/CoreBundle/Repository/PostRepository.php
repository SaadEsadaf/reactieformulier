<?php

namespace News\CoreBundle\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use News\CoreBundle\Entity\Post;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    /**
     * Finds recent posts.
     *
     * @param int $num
     *
     * @return array
     */
    public function findLatest($num)
    {
        $qb = $this->getQueryBuilder()->orderBy('p.id', 'desc')->setMaxResults($num);

        return $qb->getQuery()->getResult();
    }

    /**
     * Gets a new QueryBuilder instance.
     *
     * @return QueryBuilder
     */
    private function getQueryBuilder()
    {
        $em = $this->getEntityManager();

        return $em->getRepository('NewsCoreBundle:Post')->createQueryBuilder('p');
    }
}