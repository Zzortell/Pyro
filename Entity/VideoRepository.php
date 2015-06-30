<?php

namespace Zz\PyroBundle\Entity;

/**
 * VideoRepository
 */
class VideoRepository extends \Doctrine\ORM\EntityRepository
{
	public function exists ( $video )
	{
		return empty($this->createQueryBuilder('v')
			->where('v.id = :id')
				->setParameter('id', $video->getId())
			->getQuery()
			->getResult()
		);
	}
}