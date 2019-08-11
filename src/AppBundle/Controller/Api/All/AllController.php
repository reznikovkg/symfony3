<?php

namespace AppBundle\Controller\Api\All;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use Swagger\Annotations as SWG;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\User;

class AllController extends FOSRestController
{
    /**
     * @Rest\Get("/getStatistics")
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user"
     * )
     */
    public function getStatisticsAction(Request $request)
    {
        return new JsonResponse([
            'user' => 1
        ],JsonResponse::HTTP_OK);
    }
}
