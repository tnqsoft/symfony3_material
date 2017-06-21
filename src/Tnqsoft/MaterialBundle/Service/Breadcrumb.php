<?php

namespace Tnqsoft\MaterialBundle\Service;

use Tnqsoft\MaterialBundle\Service\Model\Link;
use Doctrine\Common\Collections\ArrayCollection;

class Breadcrumb
{
    /**
     * @var ArrayCollection
     */
    private $links;

    public function __construct()
    {
        $this->links = new ArrayCollection();
    }

    /**
     * Has Link
     *
     * @param  Link $link
     * @return booleans
     */
    public function hasLink(Link $link)
    {
        return $this->links->contains($link);
    }

    /**
     * @param Link $link
     */
    public function addLink(Link $link)
    {
        if (!$this->hasLink($link)) {
            $this->links->add($link);
        }
    }
    /**
     * @param Link $link
     */
    public function removeLink(Link $link)
    {
        if ($this->hasLink($link)) {
            $this->links->removeElement($link);
        }
    }

    /**
     * Get the value of Links
     *
     * @return ArrayCollection
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * Set the value of Links
     *
     * @param ArrayCollection links
     *
     * @return self
     */
    public function setLinks(ArrayCollection $links)
    {
        $this->links = $links;

        return $this;
    }

}
