<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 01/02/17
 * Time: 19:00
 */

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use UserBundle\Form\ProfileForm;

/**
 * Class ProfileController
 * @package UserBundle\Controller
 * @method User getUser()
 */
class ProfileController extends Controller
{
    /**
     * Edit the user.
     *
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request)
    {

        $form = $this->createForm(ProfileForm::class, $this->getUser());
        $form->handleRequest($request);
        $parameters = ['form' => $form->createView(), 'user' => $this->getUser()];

        if ($form->isSubmitted() && $form->isValid()) {
            $city = $request->request->get('profile_form')['address']['city'];
            $birthday = $request->request->get('profile_form')['birthday'];

            $city = $this->getDoctrine()->getRepository("AppBundle:City")->findOneBy(["id" => $city]);
            $this->getUser()->setBirthday(new \DateTime($birthday))->getAddress()->setCity($city);

            $this->getDoctrine()->getManager()->persist($this->getUser());
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash("success", "Votre profil a bien été mis à jour");

            return $this->redirectToRoute("fos_user_profile_show");
        }

        return $this->render('FOSUserBundle:Profile:edit.html.twig', $parameters);
    }

    /**
     * Show the user.
     * @Security("has_role('ROLE_USER')")
     * @return Response
     */
    public function showAction()
    {
        return $this->render('FOSUserBundle:Profile:show.html.twig', ['user' => $this->getUser()]);
    }

    /**
     * @Route("/cities", name="ajax_cities", options={"expose"=true})
     * @Security("has_role('ROLE_USER')")
     * @param Request $request
     * @return JsonResponse
     */
    public function getCityAction(Request $request)
    {
        if ($request->query->has("search")) {
            $city = $request->query->get("search");
            $cities = $this->getDoctrine()->getRepository("AppBundle:City")->findLike($city);

            return new JsonResponse($cities);
        }

        return new JsonResponse();
    }
}