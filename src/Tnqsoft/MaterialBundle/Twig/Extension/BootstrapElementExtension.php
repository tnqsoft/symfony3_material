<?php

namespace Tnqsoft\MaterialBundle\Twig\Extension;

use \Twig_Environment as Environment;

class BootstrapElementExtension extends \Twig_Extension
{

    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $methodOptions;

    /**
     * __construct
     *
     * @param string $template
     */
    public function __construct($template)
    {
        $this->template = $template;
        $this->methodOptions = array(
            'needs_environment' => true,
            'is_safe' => array('html')
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions() {
        return array(
            new \Twig_SimpleFunction('table_start', array($this, 'genTableStart'), $this->methodOptions),
            new \Twig_SimpleFunction('table_end', array($this, 'genTableEnd'), $this->methodOptions),
            new \Twig_SimpleFunction('icon', array($this, 'genIcon'), $this->methodOptions),
            new \Twig_SimpleFunction('button', array($this, 'genButton'), $this->methodOptions),
            new \Twig_SimpleFunction('link_button', array($this, 'genLinkButton'), $this->methodOptions),
            new \Twig_SimpleFunction('modal_delete', array($this, 'genModalDelete'), $this->methodOptions),
        );
    }

    /**
     * Generate table start
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genTableStart(\Twig_Environment $env, array $options = array()) {
        return $env->loadTemplate($this->template)->renderBlock('start', $options);
    }

    /**
     * Generate table end
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genTableEnd(\Twig_Environment $env, array $options = array()) {
        return $env->loadTemplate($this->template)->renderBlock('end', $options);
    }

    /**
     * Generate icon fontawesome
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genIcon(\Twig_Environment $env, array $options = array()) {
        return $env->loadTemplate($this->template)->renderBlock('icon', $options);
    }

    /**
     * Generate button
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genButton(\Twig_Environment $env, array $options = array()) {
        $default = array(
            'type' => 'button',
            'class' => 'default'
        );
        $options = array_replace_recursive($default, $options);
        return $env->loadTemplate($this->template)->renderBlock('button', $options);
    }

    /**
     * Generate button
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genLinkButton(\Twig_Environment $env, array $options = array()) {
        $default = array(
            'href' => '#',
            'class' => 'default'
        );
        $options = array_replace_recursive($default, $options);
        return $env->loadTemplate($this->template)->renderBlock('linkButton', $options);
    }

    /**
     * Generate modal delete
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genModalDelete(\Twig_Environment $env, array $options = array())
    {
        $default = array(
            'id' => 'modalDelete',
            'class' => null,
            'attr' => 'data-confirm="false"',
            'size' => 'modal-sm',
        );
        $options = array_replace_recursive($default, $options);
        return $env->loadTemplate($this->template)->renderBlock('modalDelete', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'boostrap_element_extension';
    }
}
