<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use AppBundle\Entity\Travel;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Adapter\AdapterInterface;

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
     * @param Request $request
     * @return Response
     */
    public function detailAction(Travel $travel, Request $request)
    {
        if ($request->request->has("joining")) {
            $order = new Order();
            $order->setTravel($travel)->setUser($this->getUser())->setAmount($travel->getPrice())->setDone(false);
            $this->getDoctrine()->getManager()->persist($order);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("detail_page", ['id' => $travel->getId()]);
        }

        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:voyages.html.twig', ['travel' => $travel]);
    }

    /**
     * @Route("/list/{page}/{sort}/{order}", defaults={"page" = 1, "sort" = "id", "order" = "desc"}
     *     , name="travel_list", requirements={ "sort": "id|title|places|interests", "order": "asc|desc"})
     * @ParamConverter("adapter", class="AppBundle:Travel", options={
     *     "repository_method" = "paginator",
     *     "mapping"={"sort": "sort", "order": "order"},
     *     "map_method_signature" = true
     *     })
     * @param int $page
     * @param string $sort
     * @param string $order
     * @param AdapterInterface $adapter
     * @return Response
     */
    public function listAction($page, $sort, $order, AdapterInterface $adapter)
    {
        $order = strtolower($order);
        $opposit = ["desc" => "asc", "asc" => "desc"];
        $criteras = ['id', 'title', 'places', "interests"];

        try {
            $pagerfanta = new Pagerfanta($adapter);
            $travels = $pagerfanta->setMaxPerPage(20)->setCurrentPage($page)->getCurrentPageResults();
        } catch (NotValidCurrentPageException $e) {
            return $this->redirectToRoute("travel_list", ['page' => 1, 'sort' => $sort, 'order' => $order]);
        }

        $twigArray = ['travels' => $travels, 'pager' => $pagerfanta];
        $twigArray['parameters'] = ['page' => $page, 'sort' => $sort, 'order' => $order];

        foreach ($criteras as $critera) {
            $order = $sort == $critera ? $opposit[$order] : "desc";
            $params = ["page" => $page, "sort" => $critera, "order" => $order];
            $twigArray['routes'][$critera] = $this->generateUrl("travel_list", $params);
        }

        return $this->render("AppBundle:Default:list.html.twig", $twigArray);
    }
}
