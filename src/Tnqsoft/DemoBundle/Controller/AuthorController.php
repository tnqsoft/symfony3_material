<?php

namespace Tnqsoft\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Tnqsoft\DemoBundle\Entity\Author;
use Tnqsoft\DemoBundle\Form\AuthorType;

/**
 * Author controller.
 *
 * @Route("author")
 */
class AuthorController extends Controller
{
    /**
     * Lists all entities.
     *
     * @Route("/", name="admin_author_list")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $page = $request->query->get('page', 1);
        $limit = $request->query->get('limit', 15);
        $orderBy = $request->query->get('orderBy', 'name');
        $orderDir = $request->query->get('orderDir', 'desc');
        $keyword = $request->query->get('keyword', '');

        $em = $this->getDoctrine()->getManager();
        $authorRepository = $em->getRepository(Author::class);
        $paginator = $authorRepository->getListPagination($page, $limit, $orderBy, $orderDir, $keyword);

        return $this->render('TnqsoftDemoBundle:Author:index.html.twig', array(
            'paginator' => $paginator,
            'orderBy' => $orderBy,
            'orderDir' => $orderDir,
            'keyword' => $keyword,
        ));
    }

    /**
     * Finds and displays a entity.
     *
     * @Route("/{id}", name="admin_author_show")
     * @Method("GET")
     */
    public function showAction(Author $entity)
    {
        $deleteForm = $this->createDeleteForm($entity);

        return $this->render('TnqsoftDemoBundle:Author:show.html.twig', array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a new entity.
     *
     * @Route("/new", name="admin_author_new")
     * @Method({"GET", "POST"})
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

            return $this->redirectToRoute('admin_author_show', array('id' => $entity->getId()));
        }

        return $this->render('TnqsoftDemoBundle:Author:new.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing entity.
     *
     * @Route("/{id}/edit", name="admin_author_edit")
     * @Method({"GET", "POST"})
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

            return $this->redirectToRoute('admin_author_edit', array('id' => $entity->getId()));
        }

        return $this->render('TnqsoftDemoBundle:Author:edit.html.twig', array(
            'entity' => $entity,
            'form' => $form->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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

        return $this->redirectToRoute('admin_author_list');
    }

    /**
     * Creates a form to delete a entity.
     *
     * @param Author $entity The author entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Author $entity)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_author_delete', array('id' => $entity->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
