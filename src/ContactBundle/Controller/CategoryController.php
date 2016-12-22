<?php
namespace ContactBundle\Controller;

use ContactBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactBundle\Entity\Category;

class CategoryController extends DefaultController
{

    /**
     * @Route("/new/category", name="addCategory")
     */
    public function newCategory(Request $request)
    {
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('categories');
        } else {
            return $this->render('@Contact/addCategory.html.twig', ["form" => $form->createView()]);
        }
    }

    /**
     * @Route("/categories", name="categories")
     */
    public function showCategories()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('ContactBundle:Category')->findAll();

        return $this->render('@Contact/categories.html.twig', ['categories' => $categories]);
    }
}
