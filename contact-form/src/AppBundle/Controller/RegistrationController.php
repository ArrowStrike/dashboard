<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Member;
use AppBundle\Form\Type\MemberType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="registration")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {


        $member = new Member();
        $form = $this->createMemberRegistrationForm($member);


        return $this->render(
            'registration/register.html.twig',
            [
                'registration_form' => $form->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @Route("/registration-form-submission", name="handle_registration_form_submission")
     * @Method("POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function handleFormSubmissionAction(Request $request)
    {
        $member = new Member();
        $form = $this->createMemberRegistrationForm($member);

        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render(
                'registration/register.html.twig',
                [
                    'registration_form' => $form->createView(),
                ]
            );
        }

        $password = $this
            ->get('security.password_encoder')
            ->encodePassword(
                $member,
                $member->getPlainPassword()
            );

        $member->setPassword($password);

        $em = $this->getDoctrine()->getManager();

        $em->persist($member);
        $em->flush();


        $this->addFlash('success', 'You are successfully registered');

        return $this->redirectToRoute('homepage');

    }

    /**
     * @param $member
     * @return \Symfony\Component\Form\Form
     */
    private function createMemberRegistrationForm($member)
    {
         return $form = $this->createForm(
            MemberType::class,
            $member,
            [
                'action' => $this->generateUrl('handle_registration_form_submission')
            ]
        );
    }
}