<?php

namespace Zz\PyroBundle\Form;

use Zz\PyroBundle\Entity\VideoYtFactory;

class TypeFactory
{
	protected $ytFactory;
    
    public function __construct ( VideoYtFactory $ytFactory )
    {
        $this->ytFactory = $ytFactory;
    }
    
    public function createVideoType ()
    {
    	return new VideoType ($this->ytFactory);
    }
    
    public function createVideoAddType ()
    {
    	return new VideoAddType ($this->ytFactory);
    }
    
    public function createExtractType ()
    {
    	return new ExtractType ($this);
    }
}
