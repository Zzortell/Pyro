<?php

namespace Zz\PyroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->render('ZzPyroBundle:Index:index.html.twig');
    }
}
