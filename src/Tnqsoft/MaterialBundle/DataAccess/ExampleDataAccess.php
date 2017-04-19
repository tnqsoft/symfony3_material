<?php

namespace Tnqsoft\MaterialBundle\DataAccess;

class ExampleDataAccess extends BaseDataAccess
{
    /**
     * Get Latest Free Rooms
     *
     * @return array
     */
    public function getCurrentDate()
    {
        $sql = $this->getSqlFile('example'.DIRECTORY_SEPARATOR.'current_date.sql');
        $params = array();
        return $this->em
            ->getConnection()
            ->executeQuery($sql, $params)
            ->fetchAll();
    }
}
