<?php

namespace FrontBundle\Controller;

use CommonBundle\Entity\User;
use CommonBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    public function registrationAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            // Set their role
            $user->setRoles(['ROLE_USER']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Регистрация прошла успешно!');

            return $this->redirectToRoute('login');
        }

        return $this->render('FrontBundle:registration:register.html.twig',[
            'registration_form' => $form->createView()
        ]);
    }

    public function loginCheckAction()
    {

    }

    public function loginAction()
    {
        $helper = $this->get('security.authentication_utils');

        return $this->render('FrontBundle:registration:login.html.twig',
            [
                'last_username' => $helper->getLastUsername(),
                'error'         => $helper->getLastAuthenticationError(),
            ]
        );
    }

    public function logoutAction(Request $request)
    {
        $this->get('security.token_storage')->setToken(null);
        $request->getSession()->invalidate();

        $this->get('session')->getFlashBag()->add('success', 'Вы вышли!');

        return $this->redirectToRoute('homepage');
    }
}