<?php

namespace Tnqsoft\MaterialBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Environment as Environment;

class TableExtension extends \Twig_Extension {

    /**
     * @var Environment
     */
    private $twig;

    private $template;

    /**
     * __construct
     *
     * @param Environment $twig
     */
    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->template = $this->twig->loadTemplate('TnqsoftMaterialBundle:Common:table.html.twig');
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions() {
        return array(
            'table_start' => new \Twig_Function_Method($this, 'genTableStart', array('is_safe' => array('html'))),
            'table_end' => new \Twig_Function_Method($this, 'genTableEnd', array('is_safe' => array('html'))),
        );
    }

    /**
     * Generate table start
     *
     * @param array $options
     * @return string
     */
    public function genTableStart(array $options = array()) {
        return $this->template->renderBlock('start', $options);
    }

    /**
     * Generate table end
     *
     * @param array $options
     * @return string
     */
    public function genTableEnd(array $options = array()) {
        return $this->template->renderBlock('end', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'table_extension';
    }
}
