<?php

namespace Macao\JobBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpKernel\Exception\HttpException;
use JMS\DiExtraBundle\Annotation as DI;
use FOS\RestBundle\Controller\FOSRestController;

class ApiController extends FOSRestController
{
    private $em;

    public function getJobsAction()
    {
        $jobs = $this->em->getRepository('MacaoJobBundle:Job')->findBy(array('published' => 1), array('createdAt' => 'DESC'));
        $data = array();
        foreach($jobs as $job) {
            $data[] = array(
                'title' => $job->getTitle(),
                'slug' => $job->getSlug(),
                'category' => $job->getCategory()->getName(),
                'color' => $job->getCategory()->getColor(),
                'name' => $job->getAuthorName(),
                'email' => $job->getAuthorEmail(),
                'telephone' => $job->getAuthorTelephone(),
                'content' => $job->getContent()
            );
            
        }
        $view = $this->view($data);
 
        return $this->handleView($view, 200);
    } // "get_jobs"            [GET] /jobs

    public function getJobAction($slug)
    {
        $job = $this->em->getRepository('MacaoJobBundle:Job')->findOneBySlug($slug);
        $data = array(
            'title' => $job->getTitle(),
            'slug' => $job->getSlug(),
            'category' => $job->getCategory()->getName(),
            'color' => $job->getCategory()->getColor(),
            'name' => $job->getAuthorName(),
            'email' => $job->getAuthorEmail(),
            'telephone' => $job->getAuthorTelephone(),
            'content' => $job->getContent()
        );
        $view = $this->view($data);
 
        return $this->handleView($view, 200);
    } // "get_job"            [GET] /jobs/{$slug}
}