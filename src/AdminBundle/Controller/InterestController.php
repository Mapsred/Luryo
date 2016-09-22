<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 22/09/16
 * Time: 11:43
 */

namespace AdminBundle\Controller;

use AppBundle\Entity\Interest;
use AppBundle\Form\InterestType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InterestController
 * @package AdminBundle\Controller
 * @Route("/interest")
 */
class InterestController extends Controller
{
    /**
     * @Route("/", name="admin_interest_list")
     */
    public function listInterestAction()
    {
        $list = $this->getDoctrine()->getRepository("AppBundle:Interest")->findAll();

        return $this->render("AdminBundle:Travel:list.html.twig", ['interests' => $list]);
    }

    /**
     * @Route("/new", name="admin_interest_new")
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(InterestType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Interest $interest */
            $interest = $form->getData();
            $this->getDoctrine()->getManager()->persist($interest);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", sprintf('Intérêt %s créé', $interest->getName()));

            return $this->redirectToRoute("admin_interest_list");
        }

        return $this->render('AdminBundle:Interest:create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="admin_interest_edit")
     * @param Request $request
     * @param Interest $interest
     * @return Response|RedirectResponse
     */
    public function editAction(Request $request, Interest $interest)
    {
        $form = $this->createForm(InterestType::class, $interest);
        $form->handleRequest($request);
        $params = ['form' => $form->createView()];

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($interest);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", sprintf('Intérêt %s créé', $interest->getName()));

            return $this->redirectToRoute("admin_interest_list");
        }

        return $this->render('AdminBundle:Interest:create.html.twig', $params);
    }
}