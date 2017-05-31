<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Template("default/index.html.twig")
     */
    public function indexAction()
    {
        if($this->container->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
            return $this->redirectToRoute("homepage");
        }
    }

    /**
     * @Route("/home", name="homepage")
     * @Template("default/homepage.html.twig")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function homePageAction(Request $request)
    {

    }
}
