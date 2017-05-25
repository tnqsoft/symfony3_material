<?php

namespace Tnqsoft\DemoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tnqsoft\MaterialBundle\Service\Paginator;

class AuthorRepository extends EntityRepository
{
    /**
     * Get list by pagination
     *
     * @param integer $page
     * @param integer $limit
     * @param string $orderBy Order By Field
     * @param string $orderDir Order Direction
     * @param string $keyword Keyword for search
     * @return PaginatorService
     */
    public function getListPagination(
        $page=1,
        $limit=15,
        $orderBy='name',
        $orderDir='ASC',
        $keyword='')
    {
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.'.$orderBy, $orderDir);

        if ($keyword !== '') {
            $query->andWhere('a.name LIKE :keyword OR n.description LIKE :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');
        }

        $dql = $query->getQuery();

        return new Paginator($dql, $page, $limit);
    }
}
