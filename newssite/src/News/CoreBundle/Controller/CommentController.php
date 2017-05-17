<?php

namespace News\CoreBundle\Controller;

use ReCaptcha\ReCaptcha;
use News\CoreBundle\Entity\Post;
use News\CoreBundle\Entity\Comment;
use News\CoreBundle\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class CommentController.
 */
class CommentController extends Controller
{
    /**
     * Creates a comment.
     *
     * @param Request $request
     * @param string $slug
     *
     * @return RedirectResponse|Response
     *
     * @Route("/{slug}/create-comment")
     * @Method("POST")
     */
    public function createCommentAction(Request $request, $slug)
    {
        $comment = new Comment;
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository("NewsCoreBundle:Post")->findOneBy(['slug' => $slug]);
       // $recaptcha = new ReCaptcha($this->getParameter('recaptcha_secret'));
       /** $resp = $recaptcha->verify($request->request->get('g-recaptcha-response'), $request->getClientIp());
        if (!$resp->isSuccess()) {
            $this->addFlash('alert', 'The reCAPTCHA wasn\'t entered correctly. Go back and try it again.');

            return $this->render('NewsCoreBundle:Post:show.html.twig', [
                'post' => $post,
                'form' => $form->createView()
            ]);
        }**/
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);
            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Your comment was submitted successfully');

            return $this->redirectToRoute('news_core_post_show', [
                'slug' => $post->getSlug()
            ]);
        }

        return $this->render('NewsCoreBundle:Post:show.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);

    }
}
