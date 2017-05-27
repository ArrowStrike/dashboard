<?php

namespace DashboardBundle\Controller;


use DashboardBundle\Entity\Message;
use MessageFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;



class DashboardController extends Controller
{
    /**
     * @Route("/add", name="addAction")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm(MessageFormType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // save data
            $this
                ->get('memcache-rep')
                ->save($message);

            // dispatch event
            $eventDispatcher = $this->container->get('event_dispatcher');
            $event = new MessageSaved($message);
            $eventDispatcher->dispatch('dashboard.add', $event);

            return $this->redirectToRoute('homepage');
        }

        return $this->render('@Dashboard/add.html.twig', ['form' => $form->createView()]);
    }


}
