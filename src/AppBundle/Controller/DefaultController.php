<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Travel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:homepage.html.twig');
    }

    /**
     * @Route("/detail/{id}", name="detail_page")
     * @param Travel $travel
     * @return Response
     */
    public function detailAction(Travel $travel)
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:voyages.html.twig', ['travel' => $travel]);
    }
}
