<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Order;
use AppBundle\Entity\Travel;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pagerfanta\Adapter\AdapterInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Default:homepage.html.twig');
    }

    /**
     * @Route("/detail/{slug}", name="detail_page")
     * @param Travel $travel
     * @param Request $request
     * @return Response
     */
    public function detailAction(Travel $travel, Request $request)
    {
        if ($travel->getStatus() == "closed") {
            $this->createNotFoundException();
        }

        if ($request->request->has("joining")) {
            $order = new Order();
            $order->setTravel($travel)->setUser($this->getUser())->setAmount($travel->getPrice())->setDone(false);
            $this->getDoctrine()->getManager()->persist($order);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute("detail_page", ['slug' => $travel->getSlug()]);
        }

        // replace this example code with whatever you need
        return $this->render('AppBundle:Default:detail.html.twig', ['travel' => $travel]);
    }

    /**
     * @Route("/list/{page}/{sort}/{order}", defaults={"page" = 1, "sort" = "id", "order" = "desc"}
     *     , name="travel_list", requirements={ "sort": "id|title|places|interests", "order": "asc|desc"}, options={"expose"=true})
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
        try {
            $pagerfanta = new Pagerfanta($adapter);
            /** @var Travel[] $travels */
            $travels = $pagerfanta->setMaxPerPage(20)->setCurrentPage($page)->getCurrentPageResults();
        } catch (NotValidCurrentPageException $e) {
            return $this->redirectToRoute("travel_list", ['page' => 1, 'sort' => $sort, 'order' => strtolower($order)]);
        }

        $twigArray = [
            'travels' => $travels,
            'pager' => $pagerfanta,
            'criteras' => [
                "Date de création" => 'id',
                "Titre" => 'title',
                "Nombre de places" => 'places',
                "Centres d'intérêts" => "interests",
            ],
        ];

        return $this->render("AppBundle:Default:list.html.twig", $twigArray);
    }

    /**
     * @Route("/checkout/{slug}", name="checkout")
     * @Security("has_role('ROLE_USER')")
     * @param Travel $travel
     * @param Request $request
     * @return Response
     */
    public function checkoutAction(Travel $travel, Request $request)
    {
        if ($travel->getStatus() == "closed") {
            $this->createNotFoundException();
        }

        $parameters = ['travel' => $travel, "paypalLink" => $this->get("app.paypal")->generatePaiementURL($travel)];
        if ($request->query->has("status")) {
            $parameters['result'] = $this->get("app.paypal")->completing($request);
        }

        return $this->render('AppBundle:Default:checkout.html.twig', $parameters);
    }

    /**
     * @Route("/search", name="search", options={"expose"=true})
     * @param Request $request
     * @return Response|NotFoundHttpException
     */
    public function searchAction(Request $request)
    {
        $keys = $request->query->keys();
        if (isset($keys[0]) && in_array($keys[0], ["date", "city", "price", "search"])) {
            try {
                $adapter = $this->getDoctrine()->getRepository("AppBundle:Travel")->searchPaginator($request);
                $page = $request->query->get("page", 1);
                $pagerfanta = new Pagerfanta($adapter);
                /** @var Travel[] $travels */
                $travels = $pagerfanta->setMaxPerPage(1)->setCurrentPage($page)->getCurrentPageResults();
            } catch (NotValidCurrentPageException $e) {
                return $this->createNotFoundException($e->getMessage());
            }

            $twigArray = [
                'travels' => $travels,
                'pager' => $pagerfanta,
                'criteras' => [
                    "Date de création" => 'id',
                    "Titre" => 'title',
                    "Nombre de places" => 'places',
                    "Centres d'intérêts" => "interests",
                ],
            ];

            return $this->render("AppBundle:Default:list.html.twig", $twigArray);
        }

        $travels = $this->getDoctrine()->getRepository("AppBundle:Travel")->findRand(5);

        return $this->render('AppBundle:Default:search.html.twig', ["travels" => $travels]);
    }
}
