<?php

namespace Tnqsoft\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Tnqsoft\MaterialBundle\Controller\BaseCrudController;

/**
 * Category controller.
 *
 * @Route("category")
 */
class CategoryController extends BaseCrudController
{
    /**
     * @Route("/category", name="admin_category_list")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $newsCategoryRepository = $em->getRepository(NewsCategory::class);

        if ($request->isMethod('POST')) {
            $params = $request->request->all();
            foreach ($params['categories'] as $id => $values) {
                $parentId = Utility::valueOf($values, 'parent');
                $parent = null;
                if (!empty($parentId)) {
                    $parent = $newsCategoryRepository->findOneById($parentId);
                }
                $category = $newsCategoryRepository->findOneById($id);
                $category->setName(Utility::valueOf($values, 'name'));
                $category->setSlug(Utility::valueOf($values, 'slug'));
                $category->setOrdering(Utility::valueOf($values, 'ordering'));
                $category->setParent($parent);
                $category->setIsActive(Utility::valueOf($values, 'active', false, true));
                $em->persist($category);
                $em->flush();
            }

            $request->getSession()->getFlashBag()->add('success', 'Cập nhật Danh mục thành công');
            $urlRedirect = $this->generateUrl('news_category', array());
            return $this->redirect($urlRedirect);
        }

        $categories = $newsCategoryRepository->findBy(array('parent' => null), array('ordering' => 'ASC'));

        return $this->render('AppBundle:News:category.html.twig', array(
            'categories' => $categories
        ));
    }

    //Implemnet Abstract Method------------------------------------
    /**
     * Get Route Prefix
     *
     * @return string
     */
    public function getRoutePrefix()
    {
        return 'admin_category';
    }

    /**
     * Get Template Folder
     *
     * @return string
     */
    public function getTemplateFolder()
    {
        return 'TnqsoftDemoBundle:News';
    }
}
