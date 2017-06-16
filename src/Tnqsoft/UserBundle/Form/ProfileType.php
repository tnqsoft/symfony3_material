<?php

namespace Tnqsoft\UserBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\CallbackTransformer;
use Tnqsoft\UserBundle\Form\DataTransformer\RolesTransformer;

class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isNew = is_null($builder->getData()->getId());

        $builder
            ->add('email', EmailType::class, array(
                'label' => 'entity.user.email',
                //'attr' => array('placeholder' => 'Email'),
            ))
            ->add('fullname', TextType::class, array(
                'label' => 'entity.user.fullname',
                //'attr' => array('placeholder' => 'Họ và tên'),
            ))
            ->add('phone', TextType::class, array(
                'label' => 'entity.user.phone',
                //'attr' => array('placeholder' => 'Điện thoại'),
            ))
            ->add('description', TextareaType::class, array(
                'label' => 'entity.user.description',
                'required' => false
                //'attr' => array('placeholder' => 'Điện thoại'),
            ))
            ->add('avatar', HiddenType::class, array(
                'label' => 'entity.user.avatar',
                //'attr' => array('placeholder' => 'Ảnh đại diện'),
                'required' => false,
            ))
            ->add('bankName', TextType::class, array(
                'label' => 'entity.user.bank_name',
                //'attr' => array('placeholder' => 'Ngân hàng'),
                'required' => false,
            ))
            ->add('bankBranch', TextType::class, array(
                'label' => 'entity.user.bank_branch',
                //'attr' => array('placeholder' => 'Chí nhánh'),
                'required' => false,
            ))
            ->add('accountName', TextType::class, array(
                'label' => 'entity.user.account_name',
                //'attr' => array('placeholder' => 'Chủ tài khoản'),
                'required' => false,
            ))
            ->add('accountNumber', TextType::class, array(
                'label' => 'entity.user.account_number',
                //'attr' => array('placeholder' => 'Số tài khoản'),
                'required' => false,
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'text.btn_save',
                'attr' => array(
                    'iconLeft' => 'fa fa-save'
                )
            ))
        ;
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CommonBundle\Entity\User',
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmUser';
    }
}
