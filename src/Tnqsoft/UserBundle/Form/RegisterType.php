<?php

namespace Tnqsoft\UserBundle\Form\Type\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegisterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'label' => 'entity.user.type',
                'choices'  => array(
                    'text.account_type_receiption' => '1',
                    'text.account_type_boss' => '2',
                ),
                'placeholder' => 'text.choice_account_type',
                'required' => true,
                'mapped' => false,
            ))
            ->add('username', TextType::class, array(
                'label' => 'entity.user.username',
                'attr' => array('placeholder' => 'Chấp nhận a-z, A-Z, 0-9, _, - và tối thiểu 3 ký tự'),
            ))
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message' => 'password_confirm_invalid',
                'options' => array('attr' => array('class' => 'password-field')),
                'required' => true,
                'first_options'  => array('label' => 'entity.user.password'),
                'second_options' => array('label' => 'entity.user.confirm_password'),
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
            ->add('identification', TextType::class, array(
                'label' => 'entity.user.identification',
                // 'translation_domain' => 'entity',
                //'attr' => array('placeholder' => 'Họ và tên'),
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
            //'allow_extra_fields' => true
        ));
    }
    /**
     * @return string
     */
    public function getName()
    {
        return 'frmRegister';
    }
}
