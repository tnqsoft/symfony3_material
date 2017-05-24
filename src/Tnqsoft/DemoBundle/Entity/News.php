<?php

namespace Tnqsoft\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * News
 *
 * @ORM\Table(name="tbl_news")
 * @ORM\Entity
 */
class News
{
    /**
     * @var integer
     *
     * @ORM\Column(name="category_id", type="integer", nullable=true)
     */
    private $categoryId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="author_id", type="datetime", nullable=true)
     */
    private $authorId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255, nullable=false)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="text", nullable=true)
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=false)
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="thumb", type="string", length=255, nullable=true)
     */
    private $thumb;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expired_at", type="datetime", nullable=true)
     */
    private $expiredAt;

    /**
     * @var string
     *
     * @ORM\Column(name="test_color", type="string", length=255, nullable=true)
     */
    private $testColor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="test_time", type="time", nullable=true)
     */
    private $testTime;

    /**
     * @var integer
     *
     * @ORM\Column(name="test_autocomplete", type="integer", nullable=true)
     */
    private $testAutocomplete;

    /**
     * @var string
     *
     * @ORM\Column(name="test_map_latitude", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $testMapLatitude;

    /**
     * @var string
     *
     * @ORM\Column(name="test_map_longitude", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $testMapLongitude;

    /**
     * @var string
     *
     * @ORM\Column(name="test_suggesstion", type="string", length=255, nullable=true)
     */
    private $testSuggesstion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return TblNews
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * Set authorId
     *
     * @param \DateTime $authorId
     *
     * @return TblNews
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * Get authorId
     *
     * @return \DateTime
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return TblNews
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return TblNews
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set summary
     *
     * @param string $summary
     *
     * @return TblNews
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * Get summary
     *
     * @return string
     */
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return TblNews
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set thumb
     *
     * @param string $thumb
     *
     * @return TblNews
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;

        return $this;
    }

    /**
     * Get thumb
     *
     * @return string
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * Set expiredAt
     *
     * @param \DateTime $expiredAt
     *
     * @return TblNews
     */
    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * Get expiredAt
     *
     * @return \DateTime
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * Set testColor
     *
     * @param string $testColor
     *
     * @return TblNews
     */
    public function setTestColor($testColor)
    {
        $this->testColor = $testColor;

        return $this;
    }

    /**
     * Get testColor
     *
     * @return string
     */
    public function getTestColor()
    {
        return $this->testColor;
    }

    /**
     * Set testTime
     *
     * @param \DateTime $testTime
     *
     * @return TblNews
     */
    public function setTestTime($testTime)
    {
        $this->testTime = $testTime;

        return $this;
    }

    /**
     * Get testTime
     *
     * @return \DateTime
     */
    public function getTestTime()
    {
        return $this->testTime;
    }

    /**
     * Set testAutocomplete
     *
     * @param integer $testAutocomplete
     *
     * @return TblNews
     */
    public function setTestAutocomplete($testAutocomplete)
    {
        $this->testAutocomplete = $testAutocomplete;

        return $this;
    }

    /**
     * Get testAutocomplete
     *
     * @return integer
     */
    public function getTestAutocomplete()
    {
        return $this->testAutocomplete;
    }

    /**
     * Set testMapLatitude
     *
     * @param string $testMapLatitude
     *
     * @return TblNews
     */
    public function setTestMapLatitude($testMapLatitude)
    {
        $this->testMapLatitude = $testMapLatitude;

        return $this;
    }

    /**
     * Get testMapLatitude
     *
     * @return string
     */
    public function getTestMapLatitude()
    {
        return $this->testMapLatitude;
    }

    /**
     * Set testMapLongitude
     *
     * @param string $testMapLongitude
     *
     * @return TblNews
     */
    public function setTestMapLongitude($testMapLongitude)
    {
        $this->testMapLongitude = $testMapLongitude;

        return $this;
    }

    /**
     * Get testMapLongitude
     *
     * @return string
     */
    public function getTestMapLongitude()
    {
        return $this->testMapLongitude;
    }

    /**
     * Set testSuggesstion
     *
     * @param string $testSuggesstion
     *
     * @return TblNews
     */
    public function setTestSuggesstion($testSuggesstion)
    {
        $this->testSuggesstion = $testSuggesstion;

        return $this;
    }

    /**
     * Get testSuggesstion
     *
     * @return string
     */
    public function getTestSuggesstion()
    {
        return $this->testSuggesstion;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return TblNews
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return TblNews
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
