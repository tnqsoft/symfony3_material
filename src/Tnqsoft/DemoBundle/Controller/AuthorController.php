<?php

namespace Tnqsoft\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Tnqsoft\MaterialBundle\Controller\BaseCrudController;

use Tnqsoft\DemoBundle\Entity\Author;
use Tnqsoft\DemoBundle\Form\AuthorType;

/**
 * Author controller.
 *
 * @Route("author")
 */
class AuthorController extends BaseCrudController
{
    /**
     * Lists all entities.
     *
     * @Route("/", name="admin_author_list")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $criteria = $this->getCriteriaQuery($request);

        $em = $this->getDoctrine()->getManager();
        $authorRepository = $em->getRepository(Author::class);
        $paginator = $authorRepository->getListPagination($criteria);

        return $this->render($this->getTemplateFolder().':index.html.twig', array(
            'paginator' => $paginator,
            'criteria' => $criteria,
        ));
    }

    /**
     * Creates a new entity.
     *
     * @Route("/new", name="admin_author_new")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function newAction(Request $request)
    {
        $entity = new Author();
        $form = $this->createForm(AuthorType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->addFlasMessage('success', 'Create success');

            if (($request->request->has('btnSaveAndAdd'))) {
                return $this->redirectToRoute($this->getRouteNameFull('new'));
            } else {
                return $this->redirectToRoute($this->getRouteNameFull('show'), array('id' => $entity->getId()));
            }
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a entity.
     *
     * @Route("/{id}", name="admin_author_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Author $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing entity.
     *
     * @Route("/{id}/edit", name="admin_author_edit")
     * @Method({"GET", "POST"})
     * @Template()
     */
    public function editAction(Request $request, Author $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);
        $form = $this->createForm(AuthorType::class, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $this->getDoctrine()->getManager()->flush();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->addFlasMessage('success', 'Update success');
            return $this->redirectToRoute($this->getRouteNameFull('edit'), array('id' => $entity->getId()));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a author entity.
     *
     * @Route("/{id}", name="admin_author_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Author $entity)
    {
        $form = $this->createDeleteForm($entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
        }

        $this->addFlasMessage('warning', 'Delete success');

        return $this->redirectToRoute($this->getRouteNameFull('list'));
    }

    //Implemnet Abstract Method------------------------------------
    /**
     * Get Route Prefix
     *
     * @return string
     */
    public function getRoutePrefix()
    {
        return 'admin_author';
    }

    /**
     * Get Template Folder
     *
     * @return string
     */
    public function getTemplateFolder()
    {
        return 'TnqsoftDemoBundle:Author';
    }
}
