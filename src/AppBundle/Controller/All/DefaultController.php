<?php

namespace AppBundle\Controller\All;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="all.main")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@App/default/index.html.twig');
    }
}
