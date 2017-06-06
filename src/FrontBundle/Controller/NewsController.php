<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryNews = $em->getRepository('CommonBundle:News')->getAllNews();
        $query = $queryNews->getQuery();

        $pageRange = $this->getParameter('page_range');
        $paginator = $this->get('knp_paginator');

        $news_list = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            $pageRange/*limit per page*/
        );

        return $this->render('FrontBundle:news:index.html.twig', [
            'news_list' => $news_list
        ]);
    }

    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('CommonBundle:News')->findOneBy(['id' => $id]);

        if (!$news) {
            throw $this->createNotFoundException();
        }

        return $this->render('FrontBundle:news:show.html.twig', [
            'news' => $news
        ]);
    }
}