<?php
namespace Tnqsoft\MaterialBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;

/**
 * @author Nguyen Nhu Tuan <tuanquynh0508@gmail.com>
 *
 * Usage:
 * use Tnqsoft\MaterialBundle\Form\Type\TreeChoiceType;
 *
 * ->add('categories', TreeChoiceType::class, array(
 *      'class' => 'CommonBundle:NewsCategory',
 *      'multiple' => true,
 *      'required' => true,
 *      'label' => 'entity.news.categories',
 *  ))
 */
class TreeChoiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $choices = [];
        foreach ($view->vars['choices'] as $choice) {
            if ($choice->data->getParent() === null) {
                $choices[ $choice->value ] = $choice->data;
            }
        }
        $choices = $this->buildTreeChoices($choices);
        $view->vars['choices'] = $choices;
    }

    /**
     * Build Tree Choices
     *
     * @param  array  $choices
     * @param  integer $level
     * @return array
     */
    protected function buildTreeChoices($choices, $level = 0)
    {
        $result = array();
        foreach ($choices as $choice) {
            $result[] = new ChoiceView(
                $choice,
                (string)$choice->getId(),
                str_repeat('--', $level) . ' ' . $choice->getName(),
                []
            );
            if (!$choice->getChildren()->isEmpty()) {
                $result = array_merge(
                    $result,
                    $this->buildTreeChoices($choice->getChildren(), $level + 1)
                );
            }
        }

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return EntityType::class;
    }
}
