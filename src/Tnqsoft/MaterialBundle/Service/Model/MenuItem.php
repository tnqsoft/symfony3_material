<?php
namespace Tnqsoft\MaterialBundle\Service\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * MenuItem
 * @ExclusionPolicy("all")
 */
class MenuItem
{
    /**
     * @var string
     *
     * @Type("string")
     * @Expose
     */
    private $name;

    /**
     * @var boolean
     *
     * @Type("boolean")
     * @Expose
     */
    private $externalLink;

    /**
     * @var string
     *
     * @Type("string")
     * @Expose
     */
    private $routerName;

    /**
     * @var array
     *
     * @Type("array")
     * @Expose
     */
    private $routerParams;

    /**
     * @var boolean
     *
     * @Type("boolean")
     * @Expose
     */
    private $isActive;

    /**
     * @var ArrayCollection
     *
     * @Type("ArrayCollection<CommonBundle\Service\Model\MenuItem>")
     * @Expose
     */
    protected $children;

    public function __construct($name, $routerName, array $routerParams=array(), $externalLink=false)
    {
        $this->name = $name;
        $this->routerName = $routerName;
        $this->routerParams = $routerParams;
        $this->externalLink = $externalLink;
        $this->isActive = false;
        $this->children = new ArrayCollection();
    }

    /**
     * Get the value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param string name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Router Name
     *
     * @return string
     */
    public function getRouterName()
    {
        return $this->routerName;
    }

    /**
     * Set the value of Router Name
     *
     * @param string routerName
     *
     * @return self
     */
    public function setRouterName($routerName)
    {
        $this->routerName = $routerName;

        return $this;
    }

    /**
     * Get the value of Router Params
     *
     * @return array
     */
    public function getRouterParams()
    {
        return $this->routerParams;
    }

    /**
     * Set the value of Router Params
     *
     * @param array routerParams
     *
     * @return self
     */
    public function setRouterParams(array $routerParams)
    {
        $this->routerParams = $routerParams;

        return $this;
    }

    /**
     * Get the value of Is Active
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set the value of Is Active
     *
     * @param boolean isActive
     *
     * @return self
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get the value of Children
     *
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set the value of Children
     *
     * @param ArrayCollection children
     *
     * @return self
     */
    public function setChildren(ArrayCollection $children)
    {
        $this->children = $children;

        return $this;
    }

    /**
     * Has Child
     *
     * @param  MenuItem $child
     * @return boolean
     */
    public function hasChild(MenuItem $child)
    {
        return $this->children->contains($child);
    }

    /**
     * @param MenuItem $child
     */
    public function addChild(MenuItem $child)
    {
        if (!$this->hasChild($child)) {
            $this->children->add($child);
        }
    }
    /**
     * @param MenuItem $child
     */
    public function removeChild(MenuItem $child)
    {
        if ($this->hasChild($child)) {
            $this->children->removeElement($child);
        }
    }


    /**
     * Get the value of External Link
     *
     * @return boolean
     */
    public function getExternalLink()
    {
        return $this->externalLink;
    }

    /**
     * Set the value of External Link
     *
     * @param boolean externalLink
     *
     * @return self
     */
    public function setExternalLink($externalLink)
    {
        $this->externalLink = $externalLink;

        return $this;
    }

}
