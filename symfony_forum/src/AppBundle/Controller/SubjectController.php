<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Subject;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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
     */
    public function newAction(Request $request)
    {
        $subject = new Subject();
        $forum = $this->get("app.forum");
        $form = $this->createForm('AppBundle\Form\SubjectType', $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $forum->getUser();
            $em = $this->getDoctrine()->getManager();
            $subject->setUser($user);
            $em->persist($subject);
            $em->flush();

            return $this->redirectToRoute('subject_show', array('id' => $subject->getId()));
        }

        return $this->render('subject/new.html.twig', array(
            'subject' => $subject,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a subject entity.
     *
     * @Route("/{subject}", name="subject_show")
     * @Method("GET")
     */
    public function showAction(Subject $subject)
    {
        $deleteForm = $this->createDeleteForm($subject);

        return $this->render('subject/show.html.twig', array(
            'subject' => $subject,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a subject entity.
     *
     * @Route("/{id}", name="subject_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Subject $subject)
    {
        $form = $this->createDeleteForm($subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($subject);
            $em->flush();
        }

        return $this->redirectToRoute('subject_index');
    }

    /**
     * Creates a form to delete a subject entity.
     *
     * @param Subject $subject The subject entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Subject $subject)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('subject_delete', array('id' => $subject->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
