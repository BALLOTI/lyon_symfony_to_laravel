<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('default/index.html.twig', [
            "data" => $this->get("app.forum")->getAllSubjects(),
        ]);
    }

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        $user = new User;
        $authUtils = $this->get('security.authentication_utils');
        $form = $this->createForm('AppBundle\Form\LoginType', $user);
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();
        return $this->render(':default:login.html.twig', array(
            'error'         => $error,
            'lastUsername'  => $lastUsername,
            'form'          => $form->createView(),
        ));
    }
}
