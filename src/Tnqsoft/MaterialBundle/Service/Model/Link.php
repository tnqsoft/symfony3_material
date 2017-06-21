<?php

namespace Tnqsoft\MaterialBundle\Service\Model;

use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Link
 * @ExclusionPolicy("all")
 */
class Link
{
    /**
     * @var string
     *
     * @Type("string")
     * @Expose
     */
    private $icon;

    /**
     * @var string
     *
     * @Type("string")
     * @Expose
     */
    private $label;

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
    private $keepParams;

    public function __construct($label, $routerName, array $routerParams = array(), $keepParams = true, $icon = null)
    {
        $this->label = $label;
        $this->routerName = $routerName;
        $this->routerParams = $routerParams;
        $this->keepParams = $keepParams;
        $this->icon = $icon;
    }

    /**
     * Get the value of Icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set the value of Icon
     *
     * @param string icon
     *
     * @return self
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get the value of Label
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set the value of Label
     *
     * @param string label
     *
     * @return self
     */
    public function setLabel($label)
    {
        $this->label = $label;

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
     * Get the value of Keep Params
     *
     * @return boolean
     */
    public function getKeepParams()
    {
        return $this->keepParams;
    }

    /**
     * Set the value of Keep Params
     *
     * @param boolean keepParams
     *
     * @return self
     */
    public function setKeepParams($keepParams)
    {
        $this->keepParams = $keepParams;

        return $this;
    }

}
