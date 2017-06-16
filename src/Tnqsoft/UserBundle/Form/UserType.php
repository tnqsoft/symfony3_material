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

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $isNew = is_null($builder->getData()->getId());

        $builder
            ->add('roles', ChoiceType::class, array(
                'label' => 'entity.user.type',
                'choices'  => array(
                    'text.account_type_admin' => 'ROLE_ADMIN',
                    'text.account_type_employe' => 'ROLE_EMPLOYE',
                    'text.account_type_receiption' => 'ROLE_RECEIPTION',
                    'text.account_type_boss' => 'ROLE_HOTEL_BOSS',
                ),
                'placeholder' => 'text.choice_account_type',
                'required' => true
            ))
            ->add('username', TextType::class, array(
                'label' => 'entity.user.username',
                //'attr' => array('placeholder' => 'Tài khoản'),
            ))
            ->add('newPassword', PasswordType::class, array(
                'label' => 'entity.user.password',
                'attr' => array(
                    //'placeholder' => 'Mật khẩu',
                    'help'=> ($isNew === false)?'text.help_password':''
                ),
                'required' => $isNew,
            ))
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
            ->add('identification', TextType::class, array(
                'label' => 'entity.user.identification',
                //'attr' => array('placeholder' => 'Điện thoại'),
            ))
            ->add('commissionRatio', TextType::class, array(
                'label' => 'entity.user.commission_ratio',
                //'attr' => array('placeholder' => 'Điện thoại'),
            ))
            ->add('bonusRatio', TextType::class, array(
                'label' => 'entity.user.bonus_ratio',
                //'attr' => array('placeholder' => 'Điện thoại'),
            ))
            ->add('receiptRatio', TextType::class, array(
                'label' => 'entity.user.receipt_ratio',
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
            ->add('isActive', null, array(
                'label' => 'entity.user.is_active',
                'attr' => array('class' => 'checkbox-switch-active')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'text.btn_save',
                'attr' => array(
                    'iconLeft' => 'fa fa-save'
                )
            ))
            ->add('saveAndAdd', SubmitType::class, array(
                'label' => 'text.btn_save_and_add',
                'attr' => array(
                    'iconLeft' => 'fa fa-save'
                )
            ))
        ;

        // http://symfony.com/doc/current/form/data_transformers.html
        $transformer = new RolesTransformer();
        $builder->get('roles')->addModelTransformer($transformer);
    }
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            //'allow_extra_fields' => true,
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
