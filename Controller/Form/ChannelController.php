<?php

namespace Zz\PyroBundle\Controller\Form;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Zz\PyroBundle\Entity\Channel;
use Zz\PyroBundle\Entity\YoutubeRequestor;

class ChannelController extends Controller
{
	public function addIzzyAction( Request $request )
	{
		$yt = $this->get('zz_pyro.youtube_requestor');
		$channel = $yt->resolveChannel('izzyManiaKK');
		$yt->hydrateChannel($channel);
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($channel);
		$em->flush();
		
		dump($channel);
		
		return new Response ('Mais comme le dit Aragon : il ne faut jamais perdre espoir.');
	}
}
