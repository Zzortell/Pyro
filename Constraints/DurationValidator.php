<?php

namespace Zz\PyroBundle\Constraints;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraints\DateValidator;

class DurationValidator extends DateValidator
{
	const PATTERN = '#^P(?:\d+[YDM])*(?:T(?:\d+[HMS])*)$#';

	public function validate($value, Constraint $constraint)
	{
		if (!$constraint instanceof Duration) {
			throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Duration');
		}

		if (null === $value || '' === $value || $value instanceof \DateInterval) {
			return;
		}

		if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
			throw new UnexpectedTypeException($value, 'string');
		}

		$value = (string) $value;

		if (!preg_match(static::PATTERN, $value)) {
			if ($this->context instanceof ExecutionContextInterface) {
				$this->context->buildViolation($constraint->message)
					->setParameter('{{ value }}', $this->formatValue($value))
					->setCode(DateTime::INVALID_FORMAT_ERROR)
					->addViolation();
			} else {
				$this->buildViolation($constraint->message)
					->setParameter('{{ value }}', $this->formatValue($value))
					->setCode(DateTime::INVALID_FORMAT_ERROR)
					->addViolation();
			}

			return;
		}
	}
}
