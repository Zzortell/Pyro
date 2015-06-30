<?php

namespace Zz\PyroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Zz\PyroBundle\Entity\Video;
use Zz\PyroBundle\Form\VideoType;
use Symfony\Component\Form\FormError;

class VideoController extends Controller
{
	public function addAction( Request $request )
	{
		$video = new Video;
		
		$form = $this->createForm(
			$this->get('zz_pyro.type_factory')->createVideoAddType(),
			$video, [
				'action' => $this->generateUrl('zz_pyro_video_add')
			]
		);
		
		$form->handleRequest($request);
		
		if ( $form->isValid() ) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($video);
			$em->flush();

			return $this->render('ZzPyroBundle:Entity:confirm.html.twig');
		}
		
		return $this->render('ZzPyroBundle:Entity:add.html.twig', [
			'form' => $form->createView()
		]);
	}
}
