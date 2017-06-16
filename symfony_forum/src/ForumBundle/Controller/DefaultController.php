<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Subject;
use ForumBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/{subject}", name="homepage", requirements={"subject": "\d+"})
     * @param Subject $subject
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction($subject = null)
    {
        return $this->render('@Forum/default/index.html.twig', [
            "data" => $this->get("forum.forum")->getAllSubjects(),
            "currentSubject" => $subject
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     */
    public function loginAction()
    {
        $user = new User;
        $authUtils = $this->get('security.authentication_utils');
        $form = $this->createForm('ForumBundle\Form\LoginType', $user);
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('@Forum/default/login.html.twig', array(
            'error'         => $error,
            'lastUsername'  => $lastUsername,
            'form'          => $form->createView(),
        ));
    }
}
