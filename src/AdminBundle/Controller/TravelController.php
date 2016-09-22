<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 22/09/16
 * Time: 11:43
 */

namespace AdminBundle\Controller;

use AppBundle\Entity\Travel;
use AppBundle\Form\TravelType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TravelController
 * @package AdminBundle\Controller
 * @Route("/travel")
 */
class TravelController extends Controller
{
    /**
     * @Route("/", name="admin_travel_list")
     */
    public function listInterestAction()
    {
        $list = $this->getDoctrine()->getRepository("AppBundle:Travel")->findAll();

        return $this->render("AdminBundle:Travel:list.html.twig", ['travels' => $list]);
    }

    /**
     * @Route("/new", name="admin_travel_new")
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(TravelType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Travel $travel */
            $travel = $form->getData();
            $this->getDoctrine()->getManager()->persist($travel);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", sprintf('Voyage Intérêt %s créé', $travel->getTitle()));

            return $this->redirectToRoute("admin_travel_list");
        }

        return $this->render('AdminBundle:Travel:create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="admin_travel_edit")
     * @param Request $request
     * @param Travel $travel
     * @return Response|RedirectResponse
     */
    public function editAction(Request $request, Travel $travel)
    {
        $form = $this->createForm(TravelType::class, $travel);
        $form->handleRequest($request);
        $params = ['form' => $form->createView()];

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->persist($travel);
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", sprintf('Voyage %s créé', $travel->getTitle()));

            return $this->redirectToRoute("admin_travel_list");
        }

        return $this->render('AdminBundle:Travel:create.html.twig', $params);
    }
}