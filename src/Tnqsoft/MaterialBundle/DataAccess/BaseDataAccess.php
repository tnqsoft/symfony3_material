<?php

namespace Tnqsoft\MaterialBundle\DataAccess;

use Doctrine\ORM\EntityManager;

class BaseDataAccess
{
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * __construct
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Get Sql File
     *
     * @param  string $filename
     * @return string
     */
    protected function getSqlFile($filename)
    {
        $file = realpath(__DIR__.'/../Resources/sql/').DIRECTORY_SEPARATOR.$filename;
        if (!file_exists($file)) {
            throw new \RuntimeException('Can not found file sql '.$file);
        }
        $sql = file_get_contents($file);

        return $sql;
    }

    /**
     * Execute native Sql
     * @param  string $sql
     * @param  array  $params
     * @return array
     */
    protected function executeSql($sql, array $params=array())
    {
        return $this->em
            ->getConnection()
            ->executeQuery($sql, $params)
            ->fetch();
    }
}
