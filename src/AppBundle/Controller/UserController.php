<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class UserController extends Controller
{
    /**
     * @Route("/user/list", name="user_list")
     * @Template("user/list.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:User');

        $users = $repository->findAll();

        return array("users" => $users);
    }

    /**
     * @Route("/user/{id}/delete", name="user_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:User');

        $user = $repository->findOneById($id);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute("user_list");
    }

    /**
     * @Method({"POST"})
     * @Route("/user/toggle/admin", name="user_toggle_admin")
     */
    public function toggleAdminAction(Request $request)
    {
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:User');

        $user = $repository->findOneById($id);

        if($user->hasRole("ROLE_ADMIN"))
        {
            $user->removeRole('ROLE_ADMIN');
            $result = "cli";
        }
        else
        {
            $user->addRole("ROLE_ADMIN");
            $result = "adm";
        }

        $em->persist($user);
        $em->flush();

        return new Response($result);
    }
}