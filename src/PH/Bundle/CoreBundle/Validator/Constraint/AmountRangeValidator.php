<?php

declare(strict_types=1);

namespace PH\Bundle\CoreBundle\Validator\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class AmountRangeValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     *
     * @throws \Symfony\Component\Validator\Exception\UnexpectedTypeException
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof AmountRange) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\AmountRange');
        }

        if (null === $value) {
            return;
        }

        if (!is_numeric($value->getAmount())) {
            $this->context->buildViolation($constraint->invalidMessage)
                ->setParameter('{{ value }}', $this->formatValue($value, self::PRETTY_DATE))
                ->setCode(AmountRange::INVALID_CHARACTERS_ERROR)
                ->atPath('amount')
                ->addViolation();

            return;
        }

        $gatewayConfig = $value->getMethod()->getGatewayConfig()->getConfig();

        $min = $gatewayConfig['minAmount'];
        $max = $gatewayConfig['maxAmount'];

        if (null !== $max && null !== $value->getAmount() && $value->getAmount() > $max) {
            $this->context->buildViolation($constraint->maxMessage)
                ->setParameter('{{ value }}', $this->formatValue($value->getAmount() / 100, self::PRETTY_DATE))
                ->setParameter('{{ limit }}', $this->formatValue($max / 100, self::PRETTY_DATE))
                ->setCode(AmountRange::TOO_HIGH_ERROR)
                ->atPath('amount')
                ->addViolation();

            return;
        }

        if (null !== $min && null !== $value->getAmount() && $value->getAmount() < $min) {
            $this->context->buildViolation($constraint->minMessage)
                ->setParameter('{{ value }}', $this->formatValue($value->getAmount() / 100, self::PRETTY_DATE))
                ->setParameter('{{ limit }}', $this->formatValue($min / 100, self::PRETTY_DATE))
                ->setCode(AmountRange::TOO_LOW_ERROR)
                ->atPath('amount')
                ->addViolation();
        }
    }
}
