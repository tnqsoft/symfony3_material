<?php

namespace Tnqsoft\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Tnqsoft\MaterialBundle\Controller\BaseCrudController;
use Tnqsoft\MaterialBundle\Form\Type\DeleteType;

use Tnqsoft\AdminBundle\Entity\Page;
use Tnqsoft\AdminBundle\Form\PageType;

/**
 * Page controller.
 *
 * @Route("page")
 */
class PageController extends BaseCrudController
{
    /**
     * Lists all entities.
     *
     * @Route("/", name="admin_page_list")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $criteria = $this->getCriteriaQuery($request);

        $searchForm = $this->createSearchForm();
        $searchForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $pageRepository = $em->getRepository(Page::class);
        $paginator = $pageRepository->getListPagination($criteria);

        return $this->render('index', array(
            'paginator' => $paginator,
            'criteria' => $criteria,
            'search_form' => $searchForm->createView(),
        ));
    }

    /**
     * Creates a new entity.
     *
     * @Route("/new", name="admin_page_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Page();
        $form = $this->createForm(PageType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->addFlasMessage('success', 'Create success');

            if (($request->request->has('btnSaveAndAdd'))) {
                return $this->redirectToRouteKeepParams($this->getRouteNameFull('new'));
            } else {
                return $this->redirectToRouteKeepParams($this->getRouteNameFull('show'), array('id' => $entity->getId()));
            }
        }

        return $this->buildParams(array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing entity.
     *
     * @Route("/{id}/edit", name="admin_page_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Page $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);
        $form = $this->createForm(PageType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $this->getDoctrine()->getManager()->flush();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->addFlasMessage('success', 'Update success');
            return $this->redirectToRouteKeepParams($this->getRouteNameFull('edit'), array('id' => $entity->getId()));
        }

        return $this->buildParams(array(
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a entity.
     *
     * @Route("/{id}", name="admin_page_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Page $entity)
    {
        $form = $this->createDeleteForm();

        return $this->buildParams(array(
            'entity' => $entity,
            'delete_form' => $form->createView(),
        ));
    }

    /**
     * Deletes a author entity.
     *
     * @Route("/{id}", name="admin_page_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Page $entity)
    {
        $form = $this->createDeleteForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
        }

        $this->addFlasMessage('warning', 'Delete success');

        return $this->redirectToRouteKeepParams($this->getRouteNameFull('list'));
    }

    //Implemnet Abstract Method------------------------------------
    /**
     * Get Route Prefix
     *
     * @return string
     */
    public function getRoutePrefix()
    {
        return 'admin_page';
    }

    /**
     * Get Template Folder
     *
     * @return string
     */
    public function getTemplateFolder()
    {
        return 'TnqsoftAdminBundle:Page';
    }
}
