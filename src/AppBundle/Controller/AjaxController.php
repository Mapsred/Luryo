<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AjaxController extends Controller
{
    /**
     * @Route("/favorite", name="favorite", options={"expose"=true})
     * @param Request $request
     */
    public function ajaxFavoriteAction(Request $request)
    {
        if ($request->request->has("")) {

        }

    }
}
