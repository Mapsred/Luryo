<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use UserBundle\Entity\User;

/**
 * Class AjaxController
 * @package AppBundle\Controller
 * @method User getUser()
 */
class AjaxController extends Controller
{
    /**
     * @Route("/favorite", name="favorite", options={"expose"=true})
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxFavoriteAction(Request $request)
    {
        if (!$request->request->has("id") || !$request->request->has("action")) {
            return new JsonResponse([], 400);
        }

        $travel = $this->getDoctrine()->getRepository("AppBundle:Travel")->find($request->request->get("id"));
        if (!$travel) {
            return new JsonResponse([], 400);
        }

        if ($request->request->get("action") == "add") {
            $this->getUser()->addFavorite($travel);
        }else {
            $this->getUser()->removeFavorite($travel);
        }


        $this->getDoctrine()->getManager()->persist($this->getUser());
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(['status' => "OK"]);
    }
}
