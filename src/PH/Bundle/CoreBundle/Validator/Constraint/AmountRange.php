<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

final class AmountRange extends Constraint
{
    const INVALID_CHARACTERS_ERROR = 'cd6f6f8e-be36-11e7-abc4-cec278b6b50a';
    const TOO_HIGH_ERROR = 'cd6f761e-be36-11e7-abc4-cec278b6b50a';
    const TOO_LOW_ERROR = 'cd6f7cc2-be36-11e7-abc4-cec278b6b50a';

    protected static $errorNames = array(
        self::INVALID_CHARACTERS_ERROR => 'INVALID_CHARACTERS_ERROR',
        self::TOO_HIGH_ERROR => 'TOO_HIGH_ERROR',
        self::TOO_LOW_ERROR => 'TOO_LOW_ERROR',
    );

    public $minMessage = 'This value should be {{ limit }} or more.';
    public $maxMessage = 'This value should be {{ limit }} or less.';
    public $invalidMessage = 'This value should be a valid number.';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
