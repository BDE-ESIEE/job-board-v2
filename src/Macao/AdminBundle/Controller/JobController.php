<?php

namespace Macao\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Macao\JobBundle\Entity\Job;
use Macao\JobBundle\Form\JobType;

class JobController extends Controller
{
    private $em;
    private $paginator;

    public function indexAction(Request $request)
    {
        $jobs = $this->em->getRepository('MacaoJobBundle:Job')->findAll();
        $pagination = $this->paginator->paginate(
            $jobs,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('MacaoAdminBundle:Job:index.html.twig', array(
            'jobs' => $pagination
        ));
    }

    public function newAction(Request $request)
    {
        $job = New Job();
        $form = $this->createForm(JobType::Class, $job);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if(!$form->isValid())
            {
                return $this->render('MacaoAdminBundle:Job:new.html.twig', array(
                    'form' => $form->createView()
                ));
            }

            $this->em->persist($job);
            $this->em->flush();

            return $this->redirectToRoute('macao_admin_job_index');
        }

        return $this->render('MacaoAdminBundle:Job:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request, Job $job)
    {
        $form = $this->createForm(JobType::Class, $job);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if(!$form->isValid())
            {
                return $this->render('MacaoAdminBundle:Job:edit.html.twig', array(
                    'job' => $job,
                    'form' => $form->createView()
                ));
            }

            $this->em->persist($job);
            $this->em->flush();

            return $this->redirectToRoute('macao_admin_job_index');
        }

        return $this->render('MacaoAdminBundle:Job:edit.html.twig', array(
            'job' => $job,
            'form' => $form->createView()
        ));
    }

    public function deleteAction(Request $request, Job $job)
    {
        $this->em->remove($job);
        try
        {
            $this->em->flush();
        }
        catch (\Exception $e)
        {
            $jobs = $this->em->getRepository('MacaoJobBundle:Job')->findAll();
            $pagination = $this->paginator->paginate(
                $jobs,
                $request->query->getInt('page', 1),
                10
            );
            return $this->render('MacaoAdminBundle:Job:index.html.twig', array(
                'jobs' => $pagination,
                'error' => 'Une erreur est survenue lors de la suppression du job '.$job->getTitle()
            ));
        }

        return $this->redirectToRoute('macao_admin_job_index');
    }
}
