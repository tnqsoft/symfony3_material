<?php

namespace Tnqsoft\AdminBundle\Controller;

use Tnqsoft\MaterialBundle\Controller\BaseCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Tnqsoft\MaterialBundle\Service\Model\Link;

class DashboardController extends BaseCrudController
{
    /**
     * @Route("/", name="admin_dashboard")
     */
    public function indexAction()
    {
        return $this->render('index');
    }

    //Implemnet Abstract Method------------------------------------
    /**
     * Get Route Prefix
     *
     * @return string
     */
    public function getRoutePrefix()
    {
        return '';
    }

    /**
     * Get Template Folder
     *
     * @return string
     */
    public function getTemplateFolder()
    {
        return 'TnqsoftAdminBundle:Dashboard';
    }
}
