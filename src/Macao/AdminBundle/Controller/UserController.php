<?php

namespace Macao\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\DiExtraBundle\Annotation as DI;
use Symfony\Component\HttpFoundation\Request;
use Macao\UserBundle\Entity\User;
use FOS\UserBundle\Form\Type\RegistrationFormType;

class UserController extends Controller
{
    private $em;
    private $um;
    private $paginator;

    public function indexAction(Request $request)
    {
        $users = $this->um->findUsers();
        $pagination = $this->paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('MacaoAdminBundle:User:index.html.twig', array(
            'users' => $pagination
        ));
    }

    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm(RegistrationFormType::Class, $user);

        if($request->isMethod('POST'))
        {
            $form->handleRequest($request);
            if(!$form->isValid())
            {
                return $this->render('MacaoAdminBundle:User:edit.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView()
                ));
            }

            $this->um->updateUser($user);

            return $this->redirectToRoute('macao_admin_user_index');
        }

        return $this->render('MacaoAdminBundle:User:edit.html.twig', array(
            'user' => $user,
            'form' => $form->createView()
        ));
    }

    public function deleteAction(Request $request, User $user)
    {
        try
        {
            $this->um->deleteUser($user);
        }
        catch (\Exception $e)
        {
            $users = $this->um->findUsers();
            $pagination = $this->paginator->paginate(
                $users,
                $request->query->getInt('page', 1),
                10
            );
            return $this->render('MacaoAdminBundle:Job:index.html.twig', array(
                'users' => $pagination,
                'error' => 'Une erreur est survenue lors de la suppression de l\'utilisateur '.$user->getUsername()
            ));
        }

        return $this->redirectToRoute('macao_admin_user_index');
    }
}
