<?php

namespace Zz\PyroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zz\PyroBundle\Entity\BestOf;

class BestOfController extends Controller
{
	public function addAction( Request $request )
	{
		$bestof = new BestOf;
		$bestof->setManager($this->get('zz_pyro.profile_manager')->getProfile());
		
		$form = $this->createForm(
			$this->get('zz_pyro.type_factory')->createBestOfType(),
			$bestof, [
				'action' => $this->generateUrl('zz_pyro_bestof_add')
			]
		);
		
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
