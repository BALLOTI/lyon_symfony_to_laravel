<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Comment controller.
 *
 * @Route("comment")
 */
class CommentController extends Controller
{

    /**
     * Creates a new comment entity.
     *
     * @Route("/new/{subject}", name="comment_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Subject $subject
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request, Subject $subject)
    {
        $comment = new Comment();
        $forum = $this->get("app.forum");
        $form = $this->createForm('AppBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $forum->getUser();
            $em = $this->getDoctrine()->getManager();
            $comment->setSubject($subject);
            $comment->setUser($user);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('subject_show', array('subject' => $subject->getId()));
        }

        return $this->render('comment/new.html.twig', array(
            'subject' => $subject,
            'comment' => $comment,
            'form' => $form->createView(),
        ));
    }


    /**
     * Deletes a comment entity.
     *
     * @Route("/{id}", name="comment_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Comment $comment)
    {
        $form = $this->createDeleteForm($comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('comment_index');
    }

    /**
     * Creates a form to delete a comment entity.
     *
     * @param Comment $comment The comment entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Comment $comment)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('comment_delete', array('id' => $comment->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
