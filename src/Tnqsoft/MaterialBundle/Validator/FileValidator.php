<?php

namespace Tnqsoft\MaterialBundle\Validator;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class FileValidator extends BaseValidator
{
    /**
     * Upload Validate.
     *
     * @return array
     */
    public function uploadValidate($input)
    {
        $this->collections = array(
            'file' => new Constraints\Required(array(
                new Constraints\NotBlank(),
                new Constraints\NotNull(),
                new Constraints\Image(array(
                    // 'minWidth' => 200,
                    // 'minHeight' => 200,
                    // 'maxWidth' => 800,
                    // 'maxHeight' => 800,
                    //'allowSquare' => true,
                    //'allowLandscape' => false,
                    //'allowPortrait' => false,
                    'detectCorrupted' => true,
                )),
            )),
        );

        return $this->validate($input);
    }
}
