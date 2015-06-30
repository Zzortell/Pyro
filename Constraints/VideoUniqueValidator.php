<?php

namespace Zz\PyroBundle\Constraints;

use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraints\DateValidator;

class VideoUniqueValidator extends DateValidator
{
	protected $em;
	
	public function __construct ( \Doctrine\ORM\EntityManager $em ) {
        $this->em = $em;
    }
	
	public function validate($video, Constraint $constraint)
	{
		if ( !$this->em->getRepository('ZzPyroBundle:Video')->exists($video) ) {
			$this->context->addViolation($constraint->message, array('%id%' => $video->getId()));
		}
	}
}
