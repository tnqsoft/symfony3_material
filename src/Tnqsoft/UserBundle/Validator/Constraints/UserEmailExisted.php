<?php

namespace Tnqsoft\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserEmailExisted extends Constraint
{
    public $message = 'Email %string% không tồn tại trong hệ thống.';
}
