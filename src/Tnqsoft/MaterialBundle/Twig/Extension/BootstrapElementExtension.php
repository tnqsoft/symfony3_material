<?php

namespace Tnqsoft\MaterialBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Session\Session;
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
            'needs_context' => true,
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
            new \Twig_SimpleFunction('table_head', array($this, 'genTableHead'), $this->methodOptions),
            new \Twig_SimpleFunction('icon', array($this, 'genIcon'), $this->methodOptions),
            new \Twig_SimpleFunction('button', array($this, 'genButton'), $this->methodOptions),
            new \Twig_SimpleFunction('link_button', array($this, 'genLinkButton'), $this->methodOptions),
            new \Twig_SimpleFunction('modal_delete', array($this, 'genModalDelete'), $this->methodOptions),
            new \Twig_SimpleFunction('alert', array($this, 'genAlert'), $this->methodOptions),
            new \Twig_SimpleFunction('flash_message', array($this, 'genFlashMessage'), $this->methodOptions),
            new \Twig_SimpleFunction('pagination', array($this, 'genPagination'), $this->methodOptions),
            new \Twig_SimpleFunction('search_box', array($this, 'genSearchbox'), $this->methodOptions),

        );
    }

    /**
     * Generate table start
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genTableStart(\Twig_Environment $env, $context, array $options = array()) {
        return $env->loadTemplate($this->template)->renderBlock('start', $options);
    }

    /**
     * Generate table end
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genTableEnd(\Twig_Environment $env, $context, array $options = array()) {
        return $env->loadTemplate($this->template)->renderBlock('end', $options);
    }

    /**
     * Generate table head
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genTableHead(\Twig_Environment $env, $context, array $options = array()) {
        $default = array(
            'app' => $context['app'],
        );
        $options = array_replace_recursive($default, $options);
        return $env->loadTemplate($this->template)->renderBlock('thead', $options);
    }

    /**
     * Generate pagination
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genPagination(\Twig_Environment $env, $context, array $options = array()) {
        $default = array(
            'app' => $context['app'],
            'size' => '',
        );
        $options = array_replace_recursive($default, $options);
        return $env->loadTemplate($this->template)->renderBlock('pagination', $options);
    }

    /**
     * Generate icon fontawesome
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genIcon(\Twig_Environment $env, $context, array $options = array()) {
        return $env->loadTemplate($this->template)->renderBlock('icon', $options);
    }

    /**
     * Generate button
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genButton(\Twig_Environment $env, $context, array $options = array()) {
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
    public function genLinkButton(\Twig_Environment $env, $context, array $options = array()) {
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
    public function genModalDelete(\Twig_Environment $env, $context, array $options = array())
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
     * Generate Alert
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genAlert(\Twig_Environment $env, $context, array $options = array())
    {
        $default = array(
            'type' => 'success',
            'message' => '',
        );
        $options = array_replace_recursive($default, $options);
        return $env->loadTemplate($this->template)->renderBlock('alert', $options);
    }

    /**
     * Generate flash message
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genFlashMessage(\Twig_Environment $env, $context)
    {
        $session = new Session();
        if ($session->isStarted()) {
            $session->start();
        }
        $flashBags = array(
            'success' => $session->getFlashBag()->get('success', array()),
            'warning' => $session->getFlashBag()->get('warning', array()),
            'info' => $session->getFlashBag()->get('info', array()),
            'danger' => $session->getFlashBag()->get('danger', array()),
        );
        $alerts = array();
        array_map(
            function($type, $messages) use (&$alerts, $env, $context) {
                foreach ($messages as $message) {
                    $options = array(
                        'type' => $type,
                        'message' => $message,
                    );
                    $alerts[] = $this->genAlert($env, $context, $options);
                }
            },
            array_keys($flashBags),
            $flashBags
        );

        return join("\n", $alerts);
    }

    /**
     * Generate Alert
     *
     * @param \Twig_Environment $env
     * @param array $options
     * @return string
     */
    public function genSearchbox(\Twig_Environment $env, $context, array $options = array())
    {
        return $env->loadTemplate($this->template)->renderBlock('searchbox', $options);
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'boostrap_element_extension';
    }
}
