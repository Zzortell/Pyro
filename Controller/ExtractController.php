<?php

namespace Zz\PyroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zz\PyroBundle\Entity\Extract;
use Zz\PyroBundle\Form\ExtractType;

class ExtractController extends Controller
{
	public function addAction( Request $request )
	{
		$extract = new Extract;
		$extract->setAuthor($this->get('zz_pyro.profile_manager')->getProfile());
		
		$form = $this->createForm(
			$this->get('zz_pyro.type_factory')->createExtractType(),
			$extract, [
				'action' => $this->generateUrl('zz_pyro_extract_add')
			]
		);
		
		if ( $form->handleRequest($request)->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($extract);
			$em->flush();

			return $this->render('ZzPyroBundle:Entity:confirm.html.twig');
		}
		
		return $this->render('ZzPyroBundle:Entity:add.html.twig', [
			'form' => $form->createView()
		]);
	}
}
