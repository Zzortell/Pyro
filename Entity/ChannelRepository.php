<?php

namespace Zz\PyroBundle\Entity;

class ChannelRepository extends \Doctrine\ORM\EntityRepository
{
	public function isStored ( Channel $channel )
	{
		return !empty($this->findById($channel->getId()));
	}
}
