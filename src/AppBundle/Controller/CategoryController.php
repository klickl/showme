<?php


namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Category;
use AppBundle\Form\CategoryFormType;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class CategoryController extends Controller
{
    /**
     * @Route("/category/list", name="categories_list")
     * @Template("category/list.html.twig")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Category');

        $categories = $repository->findAll();
        $hasShows = false;
        foreach($categories as $category)
        {
            $hasShows = $hasShows || $category->hasShows();
        }
        return array("categories" => $categories, "hasShows" => $hasShows);
    }

    /**
     * @Route("/category/create", name="category_create")
     * @Template("category/create.html.twig")
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('categories_list');
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/category/{id}/edit", name="category_edit")
     * @Template("category/edit.html.twig")
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Category');
        $category = $repository->findOneById($id);
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('categories_list');
        }
        return array('form' => $form->createView());
    }

    /**
     * @Route("/category/{id}/delete", name="category_delete")
     */
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Category');
        $category = $repository->findOneById($id);
        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute("categories_list");
    }
}