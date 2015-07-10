<?php

namespace Zz\PyroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zz\PyroBundle\Entity\BestOf;
use Zz\PyroBundle\Entity\Extract;

class BestOfController extends Controller
{
	public function displayAction ( BestOf $bestof )
	{
		return $this->render('ZzPyroBundle:BestOf:display.html.twig', [
			'bestof' => $bestof
		]);
	}
	
	public function addAction()
	{
		return $this->render('ZzPyroBundle:BestOf:add.html.twig');
	}
	
	public function manageAction()
	{
		$profile = $this->get('zz_pyro.profile_manager')->getProfile();
		
		$em = $this->getDoctrine()->getManager();
		
		$bestofs = $em->getRepository('ZzPyroBundle:BestOf')->findByManager($profile);
		
		return $this->render('ZzPyroBundle:BestOf:manage.html.twig', [
			'bestofs' => $bestofs
		]);
	}
}
