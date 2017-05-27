<?php

namespace Tnqsoft\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use Tnqsoft\MaterialBundle\Form\Type\SearchType;

abstract class BaseCrudController extends Controller
{
    const ABSOLUTE_URL  = UrlGeneratorInterface::ABSOLUTE_URL;
    const ABSOLUTE_PATH = UrlGeneratorInterface::ABSOLUTE_PATH;
    const RELATIVE_PATH = UrlGeneratorInterface::RELATIVE_PATH;
    const NETWORK_PATH = UrlGeneratorInterface::NETWORK_PATH;

    abstract public function getRoutePrefix();

    abstract public function getTemplateFolder();

    /**
     * Generates a URL from the given parameters.
     *
     * @param string $route         The name of the route
     * @param mixed  $parameters    An array of parameters
     * @param int    $referenceType The type of reference (one of the constants in UrlGeneratorInterface)
     * @param boolean $keepParams
     *
     * @return string The generated URL
     *
     * @see UrlGeneratorInterface
     */
    protected function generateUrl($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH, $keepParams = false)
    {
        $request = Request::createFromGlobals();
        if ($keepParams === true) {
            $parameters = array_merge($parameters, $request->query->all());
        }

        return parent::generateUrl($route, $parameters, $referenceType);
    }

    /**
     * Get Route Name Full
     *
     * @param  string $name
     * @return string
     */
    public function getRouteNameFull($name)
    {
        return $this->getRoutePrefix().'_'.$name;
    }

    /**
     * Get Criteria Query
     *
     * @param  Request $request
     * @param  integer $page
     * @param  integer $limit
     * @param  string  $defaultOrder
     * @param  string  $defaultOrderDir
     * @return array
     */
    public function getCriteriaQuery(Request $request, $page = 1, $limit = 10, $defaultOrder = 'id', $defaultOrderDir = 'DESC')
    {
        return array(
            'page' => $request->query->get('page', $page),
            'limit' => $request->query->get('limit', $limit),
            'orderBy' => $request->query->get('orderBy', $defaultOrder),
            'orderDir' => $request->query->get('orderDir', $defaultOrderDir),
            'keyword' => $request->query->get('keyword', ''),
        );
    }

    /**
     * Creates a form to delete a entity.
     *
     * @param mixed $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function createDeleteForm($entity)
    {
        return $this->createFormBuilder(null, array(
                'attr' => array(
                      'class' => 'frm-delete'
                )
            ))
            ->setAction($this->generateUrl($this->getRoutePrefix().'_delete', array('id' => $entity->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Creates a form to search a entity.
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function createSearchForm()
    {
        return $this->createForm(SearchType::class);
    }

    public function addFlasMessage($type, $message)
    {
        $session = new Session();
        if ($session->isStarted()) {
            $session->start();
        }
        $session->getFlashBag()->add($type, $message);
    }

}
