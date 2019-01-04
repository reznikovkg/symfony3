<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Product\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product", name="admin.product")
 */
class ProductController extends Controller
{
    /**
     * @Route("/list", name=".list")
     */
    public function listAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('@App/admin/product/category/list.html.twig', [
            'categories' => $categories
        ]);
    }
}
