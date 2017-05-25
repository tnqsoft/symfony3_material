<?php

namespace Tnqsoft\MaterialBundle\Twig\Extension;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Twig_Environment as Environment;

class ElementExtension extends \Twig_Extension {

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
    public function __construct(Environment $twig, $template)
    {
        $this->twig = $twig;
        $this->template = $this->twig->loadTemplate($template);
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions() {
        return array(
            'table_start' => new \Twig_Function_Method($this, 'genTableStart', array('is_safe' => array('html'))),
            'table_end' => new \Twig_Function_Method($this, 'genTableEnd', array('is_safe' => array('html'))),
            'icon' => new \Twig_Function_Method($this, 'genIcon', array('is_safe' => array('html'))),
            'button' => new \Twig_Function_Method($this, 'genButton', array('is_safe' => array('html'))),
            'link_button' => new \Twig_Function_Method($this, 'genLinkButton', array('is_safe' => array('html'))),
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
     * Generate icon fontawesome
     *
     * @param array $options
     * @return string
     */
    public function genIcon(array $options = array()) {
        return $this->template->renderBlock('icon', $options);
    }

    /**
     * Generate button
     *
     * @param array $options
     * @return string
     */
    public function genButton(array $options = array()) {
        $default = array(
            'type' => 'button',
            'class' => 'default'
        );
        $options = array_replace_recursive($default, $options);
        return $this->template->renderBlock('button', $options);
    }

    /**
     * Generate button
     *
     * @param array $options
     * @return string
     */
    public function genLinkButton(array $options = array()) {
        $default = array(
            'href' => '#',
            'class' => 'default'
        );
        $options = array_replace_recursive($default, $options);
        return $this->template->renderBlock('linkButton', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'element_extension';
    }
}
