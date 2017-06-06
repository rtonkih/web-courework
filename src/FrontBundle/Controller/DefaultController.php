<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function aboutAction()
    {
        return $this->render('@Front/about.html.twig');
    }

    public function contactAction()
    {
        return $this->render('@Front/contact.html.twig');
    }
}