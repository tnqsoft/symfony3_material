<?php

namespace Tnqsoft\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Tnqsoft\MaterialBundle\Service\Paginator;
use Doctrine\ORM\Query\Expr;

/**
 * This custom Doctrine repository is empty because so far we don't need any custom
 * method to query for application user information. But it's always a good practice
 * to define a custom repository that will be used when the application grows.
 * See http://symfony.com/doc/current/book/doctrine.html#custom-repository-classes
 *
 */
class UserRepository extends EntityRepository
{
    public function getUserByResetToken($token)
    {
        return $this->createQueryBuilder('u')
            ->where('u.resetToken = :token AND u.resetTimeout > :now')
            ->setParameter('token', $token)
            ->setParameter('now', new \DateTime())
            ->getQuery()
            ->getOneOrNullResult();
    }

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
    public function getListPagination($page=1, $limit=15, $orderBy='createdAt', $orderDir='DESC', $keyword='')
    {
        $query = $this->createQueryBuilder('u')
            ->orderBy('u.'.$orderBy, $orderDir);

        if($keyword !== '') {
            $query->andWhere('u.username LIKE :keyword OR u.email LIKE :keyword OR u.fullname LIKE :keyword OR u.phone LIKE :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');
        }

        $dql = $query->getQuery();

        return new Paginator($dql, $page, $limit);
    }

    public function getListByRolePagination($role='', $page=1, $limit=15, $orderBy='createdAt', $orderDir='DESC', $keyword='')
    {
        $query = $this->createQueryBuilder('u')
            ->orderBy('u.'.$orderBy, $orderDir);

        if(!empty($role)) {
            $query->andWhere("u.roles LIKE :roles")
            ->setParameter('roles', '%'.$role.'%');
        }

        if($keyword !== '') {
            $query->andWhere('u.username LIKE :keyword OR u.email LIKE :keyword OR u.fullname LIKE :keyword OR u.phone LIKE :keyword')
                ->setParameter('keyword', '%'.$keyword.'%');
        }

        $dql = $query->getQuery();

        return new Paginator($dql, $page, $limit);
    }

    /**
     * Get list by pagination for API
     *
     * @param integer $page
     * @param integer $limit
     * @param string $orderBy Order By Field. If prefix is '-'=DESC, not '-'=ASC
     * @param array $filter Filter for search
     * @return Paginator
     */
    public function getListPaginationForApi($page=1, $limit=10, $orderBy='createdAt', array $filter=array())
    {
        $orderDir='ASC';
        if(strpos($orderBy, '-') !== false) {
            $orderDir='DESC';
        }
        $orderBy = preg_replace('/[\+|\-]/i', '', $orderBy);

        $query = $this->createQueryBuilder('u')
            ->orderBy('u.'.$orderBy, $orderDir);

        if(!empty($filter)) {
            foreach ($filter as $field => $value) {
                if($value == 'true' || $value == 'false') {
                    $query->andWhere('u.'.$field.' = :value');
                    $query->setParameter('value', filter_var($value, FILTER_VALIDATE_BOOLEAN));
                } else {
                    $query->andWhere('u.'.$field.' LIKE :value');
                    $query->setParameter('value', '%'.$value.'%');
                }
            }
        }

        $dql = $query->getQuery();

        return new Paginator($dql, $page, $limit);
    }

    /**
     * GetUser By Roles Query Builder
     *
     * @param  string  $role
     * @param  integer  $id
     * @return DQL
     */
    public function getUserByRolesQueryBuilder($role='', $id=null)
    {
        // $hotelBossQuery = $this->createQueryBuilder('h')
        //                 ->from('CommonBundle:Hotel', 'hb')
        //                 ->andWhere('hb.id != :id');

        // if ($role == 'ROLE_HOTEL_BOSS') {
        //     $hotelBossQuery->select('b.id')
        //         ->innerJoin('hb.boss', 'b');
        // } elseif ($role == 'ROLE_RECEIPTION') {
        //     $hotelBossQuery->select('r.id')
        //         ->innerJoin('hb.reception', 'r');
        // }

        $query = $this->createQueryBuilder('u')
            //->where("u.roles IN(:roles)")
            //->setParameter('roles', array('HOTEL_BOSS'))
            ->where("u.roles LIKE :roles")
            ->andWhere('u.isActive = :active')
            ->setParameter('roles', '%'.$role.'%')
            ->setParameter('active', true)
            // ->setParameter('id', $id)
            ->orderBy('u.fullname', 'ASC');
            //->getQuery();
            //->getResult();

        // $query->andWhere($query->expr()->notIn('u.id', $hotelBossQuery->getDQL()));

        return $query;
    }

    public function getUserQueryBuilder($id)
    {
        $query = $this->createQueryBuilder('u')
            ->where("u.id = :id")
            ->setParameter('id', $id);

        return $query;
    }
}
