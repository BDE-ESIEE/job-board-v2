<?php

namespace Macao\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\DiExtraBundle\Annotation as DI;

class DefaultController extends Controller
{
    private $em;
    private $um;

    public function indexAction()
    {
        $jobs = $this->em->getRepository('MacaoJobBundle:Job')->findAll();
        $categories = $this->em->getRepository('MacaoJobBundle:Category')->findAll();
        $users = $this->um->findUsers();

        $jobVisible = 0;
        $jobTotal = 0;
        foreach($jobs as $job) {
            if($job->getPublished()) $jobVisible++;
            $jobTotal++;
        }

        return $this->render('MacaoAdminBundle:Default:index.html.twig', array(
            'published' => $jobVisible."/".$jobTotal,
            'jobs' => $jobs,
            'categories' => $categories,
            'users' => $users
        ));
    }
}
