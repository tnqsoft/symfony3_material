<?php

namespace Tnqsoft\MaterialBundle\Service;

use Doctrine\ORM\Tools\Pagination\Paginator as BasePaginator;

class Paginator extends BasePaginator
{
    /**
     * @var integer
     */
    protected $page;

    /**
     * @var integer
     */
    protected $limit;

    /**
     * @var integer
     */
    protected $totalRecord;

    /**
     * @var integer
     */
    protected $startRecord;

    /**
     * @var integer
     */
    protected $endRecord;

    /**
     * @var integer
     */
    protected $totalPage;

    /**
     * @var integer
     */
    protected $prevPage;

    /**
     * @var integer
     */
    protected $nextPage;

    /**
     * __construct
     *
     * @param Dql  $dql
     * @param integer $page
     * @param integer $limit
     */
    public function __construct($dql, $page = 1, $limit = 15)
    {
        parent::__construct($dql);

        $this->page = intval($page);
        $this->limit = ($limit <= 50)?$limit:50;

        $this->getQuery()
            ->setFirstResult($this->limit * ($this->page - 1))
            ->setMaxResults($this->limit);

        //Calculate
        $iteratorsRecord = $this->getIterator()->count();
        $this->totalRecord = $this->count();
        $this->totalPage = intval(ceil($this->totalRecord / $this->limit));
        $this->startRecord = (($this->page - 1) * $this->limit) + 1;
        $this->endRecord = $this->startRecord + $iteratorsRecord - 1;
        $this->prevPage = ($this->page - 1 > 0) ? $this->page - 1 : 1;
        $this->nextPage = ($this->page + 1 < $this->totalPage) ? $this->page + 1 : $this->totalPage;
    }

    /**
     * Smart Pagination
     *
     * @return array
     */
    public function smartPagination()
    {
        $step = 2;
        $left = $this->page - $step;
        $right = $this->page + $step + 1;
        $range = array();
        $rangeWithDots = array();
        $temp = null;

        for ($i = 1; $i <= $this->totalPage; $i++) {
            if ($i === 1 || $i === $this->totalPage || $i >= $left && $i < $right) {
                $range[] = $i;
            }
        }

        foreach ($range as $i) {
            if ($temp) {
                if ($i - $temp === 2) {
                    $rangeWithDots[] = $temp + 1;
                } elseif ($i - $temp !== 1) {
                    $rangeWithDots[] = '...';
                }
            }
            $rangeWithDots[] = $i;
            $temp = $i;
        }

        return $rangeWithDots;
    }

    /**
     * @return int
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * @return int
     */
    public function getTotalRecord()
    {
        return $this->totalRecord;
    }

    /**
     * @return int
     */
    public function getStartRecord()
    {
        return $this->startRecord;
    }

    /**
     * @return int
     */
    public function getEndRecord()
    {
        return $this->endRecord;
    }

    /**
     * @return int
     */
    public function getTotalPage()
    {
        return $this->totalPage;
    }

    /**
     * @return int
     */
    public function getPrevPage()
    {
        return $this->prevPage;
    }

    /**
     * @return int
     */
    public function getNextPage()
    {
        return $this->nextPage;
    }
}
