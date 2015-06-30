<?php

namespace Zz\PyroBundle\Form;

use Doctrine\ORM\EntityManager;
use Zz\PyroBundle\Entity\YoutubeRequestor;

class TypeFactory
{
    protected $em;
    protected $ytRequestor;
    
    public function __construct ( EntityManager $em, YoutubeRequestor $ytRequestor )
    {
        $this->em = $em;
        $this->ytRequestor = $ytRequestor;
    }
    
    public function createVideoType ()
    {
    	return new VideoType ($this->em, $this->ytRequestor);
    }
    
    public function createVideoAddType ()
    {
    	return new VideoAddType ($this->em, $this->ytRequestor);
    }
    
    public function createExtractType ()
    {
    	return new ExtractType ($this);
    }
}
