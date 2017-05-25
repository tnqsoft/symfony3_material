<?php

namespace Tnqsoft\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use Tnqsoft\DemoBundle\Entity\Author;

/**
 * Author controller.
 *
 * @Route("author")
 */
class AuthorController extends Controller
{
    /**
     * Lists all author entities.
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
}
