<?php

namespace Zz\PyroBundle\Form;

use Zz\PyroBundle\Entity\YoutubeRequestor;

class TypeFactory
{
	protected $ytRequestor;
    
    public function __construct ( YoutubeRequestor $ytRequestor )
    {
        $this->ytRequestor = $ytRequestor;
    }
    
    public function createVideoType ()
    {
    	return new VideoType ($this->ytRequestor);
    }
    
    public function createVideoAddType ()
    {
    	return new VideoAddType ($this->ytRequestor);
    }
    
    public function createExtractType ()
    {
    	return new ExtractType ($this);
    }
}
