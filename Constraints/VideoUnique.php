<?php

namespace Zz\PyroBundle\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class VideoUnique extends Constraint
{
	public $message = 'The video %id% already exists.';
	
	public function validatedBy()
	{
		return 'video_unique';
	}
	
	public function getTargets()
	{
		return self::CLASS_CONSTRAINT;
	}
}
