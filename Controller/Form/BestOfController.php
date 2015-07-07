<?php

namespace Zz\PyroBundle\Controller\Form;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zz\PyroBundle\Entity\BestOf;
use Zz\PyroBundle\Entity\Extract;

class BestOfController extends Controller
{
	public function addAction( Request $request )
	{
		$bestof = new BestOf;
		$bestof->setManager($this->get('zz_pyro.profile_manager')->getProfile());
		
		$form = $this->createForm('bestof', $bestof, [
			'action' => $this->generateUrl('zz_pyro_form_bestof_add')
		]);
		
		if ( $form->handleRequest($request)->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($bestof);
			$em->flush();

			return $this->render('ZzPyroBundle:Form:confirm.html.twig');
		}
		
		return $this->render('ZzPyroBundle:Form:form.html.twig', [
			'form' => $form->createView()
		]);
	}
	
	public function extractAction ( Request $request, BestOf $bestof )
	{
		$extract = new Extract;
		$extract
			->setAuthor($this->get('zz_pyro.profile_manager')->getProfile())
			->setBestOf($bestof)
		;
		
		$path = $this->generateUrl('zz_pyro_form_bestof_extract', [ 'id' => $bestof->getId() ]);
		
		$form = $this->createForm('bestof_extract', $extract, [
			'action' => $path
		]);
		
		if ( $form->handleRequest($request)->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($extract);
			$em->flush();

			return $this->render('ZzPyroBundle:Form:confirm.html.twig', [
				'path' => $path
			]);
		}
		
		return $this->render('ZzPyroBundle:Form:form.html.twig', [
			'form' => $form->createView()
		]);
	}
}
