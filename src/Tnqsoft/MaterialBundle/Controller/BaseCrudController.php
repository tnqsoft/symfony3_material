<?php

namespace Tnqsoft\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseCrudController extends Controller
{
    abstract public function getRoutePrefix();

    abstract public function getTemplateFolder();

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
    public function getCriteriaQuery(Request $request, $page = 1, $limit = 15, $defaultOrder = 'id', $defaultOrderDir = 'DESC')
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

}
