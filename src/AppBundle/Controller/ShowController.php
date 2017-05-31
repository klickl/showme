<?php
/**
 * Created by PhpStorm.
 * User: thib
 * Date: 02/08/2016
 * Time: 19:49
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Form\ShowFormType;
use AppBundle\Entity\Show;

class ShowController extends Controller
{
    /**
     * @Route("/show/list", name="show_list")
     * @Template("show/list.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Show');

        $shows = $repository->findAll();

        return array("shows" => $shows);
    }

    /**
     * @Route("/show/create", name="show_create")
     * @Template("show/create.html.twig")
     */
    public function createAction(Request $request)
    {
        $show = new Show();
        $form = $this->createForm(ShowFormType::class, $show);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $show->setAuthor($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($show);
            $em->flush();

            return $this->redirectToRoute('show_list');
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/show/{id}/edit", name="show_edit")
     * @Template("show/edit.html.twig")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Show');
        $show = $repository->findOneById($id);
        $form = $this->createForm(ShowFormType::class, $show);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $show->setAuthor($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($show);
            $em->flush();

            return $this->redirectToRoute('show_list');
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/show/{id}/see", name="show_see")
     * @Template("show/show.html.twig")
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Show');
        $show = $repository->findOneById($id);

        return array("show" => $show);
    }

    /**
     * @Route("/show/{id}/delete", name="show_delete")
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Show');
        $show = $repository->findOneById($id);
        if(!is_null($show)){
            $em->remove($show);
            $em->flush();
        }

        return $this->redirectToRoute("show_list");
    }
}