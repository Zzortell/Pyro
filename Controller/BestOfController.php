<?php

namespace Zz\PyroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Zz\PyroBundle\Entity\BestOf;
use Zz\PyroBundle\Entity\Extract;
use Zz\PyroBundle\Entity\Video;

class BestOfController extends Controller
{
	public function displayAction ( BestOf $bestof )
	{
		return $this->render('ZzPyroBundle:BestOf:display.html.twig', [
			'bestof' => $bestof
		]);
	}
	
	/**
	 * @ParamConverter("bestof", options={"mapping": {"id": "id"}})
	 */
	public function extractAction ( Request $request, BestOf $bestof )
	{
		$extract = new Extract;
		$extract
			->setAuthor($this->get('zz_pyro.profile_manager')->getProfile())
			->setBestOf($bestof)
		;
		
		$form = $this->createForm('bestof_extract', $extract, [
			'action' => $this->generateUrl('zz_pyro_bestof_extract', [ 'id' => $bestof->getId() ])
		]);
		
		if ( $form->handleRequest($request)->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($extract);
			$em->flush();

			return $this->render('ZzPyroBundle:Entity:confirm.html.twig');
		}
		
		return $this->render('ZzPyroBundle:Entity:form.html.twig', [
			'form' => $form->createView()
		]);
	}
	
	public function addAction( Request $request )
	{
		$bestof = new BestOf;
		$bestof->setManager($this->get('zz_pyro.profile_manager')->getProfile());
		
		$form = $this->createForm('bestof', $bestof, [
			'action' => $this->generateUrl('zz_pyro_bestof_add')
		]);
		
		if ( $form->handleRequest($request)->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($bestof);
			$em->flush();

			return $this->render('ZzPyroBundle:Entity:confirm.html.twig');
		}
		
		return $this->render('ZzPyroBundle:Entity:add.html.twig', [
			'form' => $form->createView()
		]);
	}
}
