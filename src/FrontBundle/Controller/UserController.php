<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function registrationAction()
    {
        return new Response('User registration');
    }

    public function loginAction(Request $request)
    {
        return new Response('User login');
    }
}