<?php

namespace Zz\PyroBundle\Entity;

/**
 * VideoRepository
 */
class VideoRepository extends \Doctrine\ORM\EntityRepository
{
	public function isStored ( Video $video )
	{
		return !empty($this->findById($video->getId()));
	}
}
