<?php

namespace Tnqsoft\MaterialBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ExceptionController extends Controller
{
    /**
     * @Route("/error", name="common_error")
     */
    public function errorAction(Request $request, FlattenException $exception, DebugLoggerInterface $logger = null)
    {
        return $this->render('TnqsoftMaterialBundle:Exception:error.html.twig',array(
            'exception' => $exception
        ));
    }
}
