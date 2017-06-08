<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
            $user =  $this->get("forum.forum")->getUser();
            $em = $this->getDoctrine()->getManager();
            $subject->setUser($user);
            $em->persist($subject);
            $em->flush();

            return $this->redirectToRoute('homepage', array('subject' => $subject->getId()));
        }

        return $this->render('@Forum/subject/new.html.twig', array(
            'subject' => $subject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Deletes a subject entity.
     *
     * @Route("/delete/{id}", name="subject_delete")
     * @Method({"GET", "DELETE"})
     * @param Subject $subject
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Subject $subject)
    {
        if ($this->getUser()->getId() == $subject->getUser()->getId()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subject);
            $em->flush();
            return $this->redirectToRoute('homepage');
        }
        throw new AccessDeniedException("Accés refusé !");
    }
}
