<?php

namespace Macao\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\DiExtraBundle\Annotation as DI;
use Macao\JobBundle\Entity\Job;

class DefaultController extends Controller
{
    private $em;

    public function indexAction()
    {
        $jobs = $this->em->getRepository('MacaoJobBundle:Job')->findBy(array('published' => 1), array('createdAt' => 'DESC'));
        $categories = $this->em->getRepository('MacaoJobBundle:Category')->findBy(array(), array('name' => 'ASC'));

        return $this->render('MacaoJobBundle:Default:index.html.twig', array(
            'jobs' => $jobs,
            'categories' => $categories
        ));
    }

    public function showAction(Job $job)
    {
        return $this->render('MacaoJobBundle:Default:show.html.twig', array(
            'job' => $job,
        ));
    }
}
