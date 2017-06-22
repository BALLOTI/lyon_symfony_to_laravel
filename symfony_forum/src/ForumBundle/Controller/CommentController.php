<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Comment;
use ForumBundle\Entity\Subject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
        $form = $this->createForm('ForumBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $comment->setSubject($subject);
            $comment->setUser($user);
            $em->persist($comment);
            $em->flush();
            $this->addFlash(
                'notice',
                'Votre commentaire à bien été ajouté.'
            );
            return $this->redirectToRoute('homepage', array('subject' => $subject->getId()));
        }

        return $this->render('@Forum/comment/new.html.twig', array(
            'subject' => $subject,
            'comment' => $comment,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a comment entity.
     *
     * @Route("/delete/{id}", name="comment_delete")
     * @Method({"DELETE", "GET"})
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("is_granted('delete', comment)")
     */
    public function deleteAction(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();
        $this->addFlash(
            'notice',
            'Votre commentaire à bien été supprimé.'
        );
        return $this->redirectToRoute('homepage', array("subject" => $comment->getSubject()->getId()));
    }
}
