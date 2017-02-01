<?php
/**
 * Created by PhpStorm.
 * User: maps_red
 * Date: 01/02/17
 * Time: 19:00
 */

namespace UserBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
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
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function editAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $this->createForm(ProfileForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var $userManager UserManagerInterface */
            $userManager = $this->get('fos_user.user_manager');

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

            $userManager->updateUser($user);

            if (null === $response = $event->getResponse()) {
                $response = new RedirectResponse($this->generateUrl('fos_user_profile_show'));
            }

            $event = new FilterUserResponseEvent($user, $request, $response);
            $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, $event);

            return $response;
        }

        return $this->render(
            'FOSUserBundle:Profile:edit.html.twig',
            ['form' => $form->createView(), 'user' => $this->getUser()]
        );
    }

    /**
     * Show the user.
     * @return Response
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        return $this->render('FOSUserBundle:Profile:show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/cities", name="ajax_cities", options={"expose"=true})
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