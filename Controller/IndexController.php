<?php

namespace Zz\PyroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zz\PyroBundle\Entity\Extract;
use Zz\PyroBundle\Form\ExtractType;

class IndexController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ZzPyroBundle:BestOf');
        
        $bestofList = $repo->findAll();
        
        return $this->render('ZzPyroBundle:Index:index.html.twig', [
        	'bestofList' => $bestofList
        ]);
    }
}
