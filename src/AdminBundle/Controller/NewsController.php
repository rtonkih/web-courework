<?php

namespace AdminBundle\Controller;

use CommonBundle\Entity\News;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryNews = $em->getRepository('CommonBundle:News')->getAllNews();
        $query = $em->createQuery($queryNews);

        $pageRange = $this->getParameter('page_range');
        $newsForm = $this->createForm('CommonBundle\Form\NewsType', new News());

        $paginator = $this->get('knp_paginator');
        $news = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            $pageRange/*limit per page*/
        );

        return $this->render('AdminBundle:news:index.html.twig', [
            'form' => $newsForm->createView(),
            'news' => $news
        ]);
    }

    public function newAction(Request $request)
    {
        $news = new News();
        $create_news_form = $this->createForm('CommonBundle\Form\NewsType', $news);
        $create_news_form->handleRequest($request);

        if ($create_news_form->isSubmitted()) {
            $validator = $this->get('validator');
            $errors = $validator->validate($news);

            if (count($errors) == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($news);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Новость добавлена!');
            } else {
                $errorMessage = $this->get('app.error_helper')->handleErrors($errors);
                foreach ($errorMessage as $error) {
                    $this->get('session')->getFlashBag()->add('error', $error);
                }
            }

            return $this->redirectToRoute('admin_news_index');
        }

        return $this->render('AdminBundle:news:new.html.twig', [
            'form' => $create_news_form->createView()
        ]);
    }

    public function updateAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('CommonBundle:News')->findOneBy(['id' => $id]);

        if (!$news) {
            throw $this->createNotFoundException('Unable to find news entity');
        }

        $edit_form_news = $this->createForm('CommonBundle\Form\NewsType', $news);
        $edit_form_news->handleRequest($request);

        if ($edit_form_news->isSubmitted()) {
            $validator = $this->get('validator');
            $errors = $validator->validate($news);

            if (count($errors) == 0) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($news);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Новость обновлена!');

                return $this->redirectToRoute('admin_news_index');
            } else {
                $errorMessage = $this->get('app.error_helper')->handleErrors($errors);
                foreach ($errorMessage as $error) {
                    $this->get('session')->getFlashBag()->add('error', $error);
                }
            }
        }

        return $this->render("AdminBundle:news:update.html.twig", [
            'news' => $news,
            'edit_form' => $edit_form_news->createView()
        ]);
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('CommonBundle:News')->findOneBy(['id' => $id]);

        if (!$news) {
            throw $this->createNotFoundException('Unable to find news entity');
        }

        $em->remove($news);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            $json = json_encode([
                'id' => $id
            ]);
            $response = new Response($json);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return $this->redirectToRoute('admin_news_index');
    }
}