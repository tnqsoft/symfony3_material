<?php

namespace Tnqsoft\UserBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Tnqsoft\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;

class UserEmailExistedValidator extends ConstraintValidator
{
    private $em;

    public function __construct(EntityManager $em) {
        $this->em = $em;
    }

    public function validate($value, Constraint $constraint)
    {
        $userRepository = $this->em->getRepository(User::class);
        $user = $userRepository->findOneBy(array('email' => $value));

        if (null === $user) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('%string%', $value)
                ->addViolation();
        }
    }
}
