<?php

namespace Macao\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MacaoUserBundle:Default:index.html.twig');
    }
}
