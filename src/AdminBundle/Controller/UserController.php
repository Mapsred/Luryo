<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 22/09/16
 * Time: 11:01
 */

namespace AdminBundle\Controller;

use FOS\UserBundle\Form\Type\RegistrationFormType;
use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController
 * @package AdminBundle\Controller
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="admin_user_list")
     */
    public function listUserAction()
    {
        $list = $this->getDoctrine()->getRepository("UserBundle:User")->findAll();

        return $this->render("AdminBundle:User:list.html.twig", ["users" => $list]);
    }


    /**
     * @Route("/edit/{id}", name="admin_user_edit")
     * @param Request $request
     * @param User $user
     * @return Response|RedirectResponse
     */
    public function editAction(Request $request, User $user)
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $params = ['form' => $form->createView()];

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", sprintf('Utilisateur %s modifié', $user->getUsername()));

            return $this->redirectToRoute("admin_user_list");
        }

        return $this->render('AdminBundle:User:edit.html.twig', $params);
    }

}