<?php

namespace News\CoreBundle\Controller;

use News\CoreBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PostController.
 */
class PostController extends Controller
{
    /**
     * Lists all Post entities.
     *
     * @param Request $request
     *
     * @return Response
     *
     * @Route("/")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository("NewsCoreBundle:Post")->findBy([], ['id' => 'desc']);
        $postsLimit = $this->container->getParameter('latest_posts_limit');
        $commentsLimit = $this->container->getParameter('latest_comments_limit');
        $latestPosts = $this->getDoctrine()->getRepository("NewsCoreBundle:Post")->findLatest($postsLimit);
        $latestComments = $this->getDoctrine()->getRepository("NewsCoreBundle:Comment")->findLatest($commentsLimit);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $posts,
            $request->query->getInt('page', 1),
            $this->container->getParameter('per_page_limit')
        );

        return $this->render('NewsCoreBundle:Post:index.html.twig', [
            'latestPosts' => $latestPosts,
            'latestComments' => $latestComments,
            'pagination' => $pagination
        ]);
    }

    /**
     * Finds and displays a Post entity.
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     *
     * @return Response
     *
     * @Route("/{slug}")
     * @Method("GET")
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository("NewsCoreBundle:Post")->findOneBy(['slug' => $slug]);
        if (!$post) {
            throw $this->createNotFoundException('Article was not found');
        }
        $form = $this->createForm(CommentType::class);

        return $this->render('NewsCoreBundle:Post:show.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
