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
}
