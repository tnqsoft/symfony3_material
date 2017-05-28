<?php

namespace Tnqsoft\MaterialBundle\Twig\Extension;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bridge\Twig\Extension\RoutingExtension as BaseRoutingExtension;

class RoutingExtension extends BaseRoutingExtension
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    public function __construct(Router $generator, RequestStack $requestStack)
    {
        parent::__construct($generator);
        $this->requestStack = $requestStack;
    }

    /**
     * @param string $name
     * @param array  $parameters
     * @param bool   $relative
     * @param bool   $keepParams
     *
     * @return string
     */
    public function getPath($name, $parameters = array(), $relative = false, $keepParams = false)
    {
        $request = $this->requestStack->getCurrentRequest();

        if ($keepParams === true) {
            $parameters = array_merge($parameters, $request->query->all());
        }

        return parent::getPath($name, $parameters, $relative);
    }
}
