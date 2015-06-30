<?php

namespace Zz\PyroBundle\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * An ISO 8601 duration:
 * https://en.wikipedia.org/wiki/ISO_8601#Durations
 *
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Duration extends Constraint
{
	const INVALID_FORMAT_ERROR = 1;
	const INVALID_DATE_ERROR = 2;
	const INVALID_TIME_ERROR = 3;

	protected static $errorNames = array(
		self::INVALID_FORMAT_ERROR => 'INVALID_FORMAT_ERROR',
		self::INVALID_DATE_ERROR => 'INVALID_DATE_ERROR',
		self::INVALID_TIME_ERROR => 'INVALID_TIME_ERROR',
	);

	public $message = 'This value is not a valid duration.';
}
