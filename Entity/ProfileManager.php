<?php

namespace Zz\PyroBundle\Entity;

class ProfileManager
{
	protected $securityContext;
	protected $em;

    public function __construct (
    	\Symfony\Component\Security\Core\SecurityContextInterface 	$securityContext,
    	\Doctrine\ORM\EntityManager 								$em
    ) {
        $this->securityContext = $securityContext;
        $this->em = $em;
    }
    
    public function getProfile ()
    {
    	if ( !$this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') ) {
    		throw new \LogicException("Can't get profile of a non-authenticated user.");
    	}
    	
    	$user = $this->securityContext->getToken()->getUser();
    	$repo = $this->em->getRepository('ZzPyroBundle:Profile');
    	$profile = $repo->findOneByUser($user);
        
        if ( $profile === null ) {
            $profile = new Profile;
            $profile->setUser($user);
            
            $this->em->persist($profile);
        }
    	
    	return $profile;
    }
}
