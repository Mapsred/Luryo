<?php

namespace AppBundle\Controller;

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
     * @Route("/voyage", name="voyage")
     * @return Response
     */
    public function indevoyageAction()
    {
        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:voyages.html.twig');
    }


}
