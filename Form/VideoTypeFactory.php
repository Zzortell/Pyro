<?php

namespace Zz\PyroBundle\Form;

use Zz\PyroBundle\Entity\VideoYtFactory;

class VideoTypeFactory
{
	protected $factory;
    
    public function __construct ( VideoYtFactory $factory )
    {
        $this->factory = $factory;
    }
    
    public function create ()
    {
    	return new VideoType ($this->factory);
    }
}
