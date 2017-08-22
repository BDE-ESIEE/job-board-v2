<?php

namespace Macao\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Macao\JobBundle\Entity\Category;
use Macao\JobBundle\Form\CategoryType;

class CategoryController extends Controller
{
    private $em;
    private $paginator;

    public function indexAction(Request $request)
    {
        $categories = $this->em->getRepository('MacaoJobBundle:Category')->findAll();
        $pagination = $this->paginator->paginate(
            $categories,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('MacaoAdminBundle:Category:index.html.twig', array(
            'categories' => $pagination
        ));
    }

    public function newAction(Request $request)
    {
        $category = New Category();
        $form = $this->createForm(CategoryType::Class, $category);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if(!$form->isValid())
            {
                return $this->render('MacaoAdminBundle:Category:new.html.twig', array(
                    'form' => $form->createView()
                ));
            }

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('macao_admin_category_index');
        }

        return $this->render('MacaoAdminBundle:Category:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Request $request, Category $category)
    {
        $form = $this->createForm(CategoryType::Class, $category);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if(!$form->isValid())
            {
                return $this->render('MacaoAdminBundle:Category:edit.html.twig', array(
                    'job' => $job,
                    'form' => $form->createView()
                ));
            }

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('macao_admin_category_index');
        }

        return $this->render('MacaoAdminBundle:Category:edit.html.twig', array(
            'category' => $category,
            'form' => $form->createView()
        ));
    }

    public function deleteAction(Request $request, Category $category)
    {
        $this->em->remove($category);
        try
        {
            $this->em->flush();
        }
        catch (\Exception $e)
        {
            $categories = $this->em->getRepository('MacaoJobBundle:Category')->findAll();
            $pagination = $this->paginator->paginate(
                $categories,
                $request->query->getInt('page', 1),
                10
            );
            return $this->render('MacaoAdminBundle:Category:index.html.twig', array(
                'categories' => $pagination,
                'error' => 'Une erreur est survenue lors de la suppression de la catégorie '.$category->getName()
            ));
        }

        return $this->redirectToRoute('macao_admin_category_index');
    }
}
