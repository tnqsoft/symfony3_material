<?php

namespace Tnqsoft\DemoBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tnqsoft\MaterialBundle\Service\Paginator;

use Tnqsoft\MaterialBundle\Service\Utility;

class AuthorRepository extends EntityRepository
{
    /**
     * Get list by pagination
     *
     * @param array $criteria
     * @return PaginatorService
     */
    public function getListPagination(array $criteria)
    {
        $page = Utility::valueOf($criteria, 'page', 1);
        $limit = Utility::valueOf($criteria, 'limit', 15);
        $orderBy = Utility::valueOf($criteria, 'orderBy', 'id');
        $orderDir = Utility::valueOf($criteria, 'orderDir', 'DESC');
        $keyword =  Utility::valueOf($criteria, 'keyword', '');

        $query = $this->createQueryBuilder('a')
            ->orderBy('a.'.$orderBy, $orderDir);

        if ($keyword !== '') {
            $query->andWhere('a.name LIKE :keyword OR a.description LIKE :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');
        }

        $dql = $query->getQuery();

        return new Paginator($dql, $page, $limit);
    }
}
