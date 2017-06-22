<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Subject;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Subject controller.
 *
 * @Route("subject")
 */
class SubjectController extends Controller
{
    /**
     * Creates a new subject entity.
     *
     * @Route("/new", name="subject_new")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $subject = new Subject();
        $form = $this->createForm('ForumBundle\Form\SubjectType', $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user =  $this->getUser();
            $em = $this->getDoctrine()->getManager();
            $subject->setUser($user);
            $em->persist($subject);
            $em->flush();
            $this->addFlash(
                'notice',
                'Votre sujet à bien été ajouté.'
            );
            return $this->redirectToRoute('homepage', array('subject' => $subject->getId()));
        }

        return $this->render('@Forum/subject/new.html.twig', array(
            'subject' => $subject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Delete a subject entity.
     *
     * @Route("/delete/{id}", name="subject_delete")
     * @Method({"GET", "DELETE"})
     * @param Subject $subject
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Security("is_granted('delete', subject)")
     */
    public function deleteAction(Subject $subject)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($subject);
        $em->flush();
        $this->addFlash(
            'notice',
            'Votre sujet à bien été supprimé.'
        );
        return $this->redirectToRoute('homepage');
    }
}
