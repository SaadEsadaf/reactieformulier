<?php

namespace News\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class AuthorController.
 *
 * @Route("author")
 */
class AuthorController extends Controller
{
    /**
     * Displays posts by author.
     *
     * @param Request $request
     * @param string $slug
     *
     * @throws NotFoundHttpException
     *
     * @return Response
     *
     * @Route("/{slug}")
     * @Method("GET")
     */
    public function showAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $author = $em->getRepository("NewsCoreBundle:Author")->findOneBy(['slug' => $slug]);
        $posts = $em->getRepository("NewsCoreBundle:Post")->findBy(['author' => $author], ['id' => 'desc']);
        if (!$author) {
            throw $this->createNotFoundException('Author was not found');
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts,
            $request->query->getInt('page', 1),
            $this->container->getParameter('per_page_limit')
        );

        return $this->render('NewsCoreBundle:Author:show.html.twig', [
            'author' => $author,
            'pagination' => $pagination
        ]);
    }
}
