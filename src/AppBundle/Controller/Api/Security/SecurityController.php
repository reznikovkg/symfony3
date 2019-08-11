<?php

namespace AppBundle\Controller\Api\Security;

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
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * @Rest\Route("/security")
 */
class SecurityController extends FOSRestController
{
    /**
     * @Rest\Get("/login")
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @SWG\Tag(name="Security")
     *
     * @SWG\Parameter(
     *     name="username",
     *     in="query",
     *     type="string",
     *     description="Username"
     * )
     * @SWG\Parameter(
     *     name="password",
     *     in="query",
     *     type="string",
     *     description="Password"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Login user"
     * )
     * @SWG\Response(
     *     response=400,
     *     description="Login user"
     * )
     */
    public function loginAction(Request $request)
    {
        $_username = $request->get('username');
        $_password = $request->get('password');

        // Retrieve the security encoder of symfony
        $factory = $this->get('security.encoder_factory');

        /// Start retrieve user
        // Let's retrieve the user by its username:
        // If you are using FOSUserBundle:
        $user_manager = $this->get('fos_user.user_manager');
        $user = $user_manager->findUserByUsername($_username);
        // Or by yourself
        /**
         * @var User
         */
        $user = $this->getDoctrine()->getManager()->getRepository(User::class)
            ->findOneBy(['username' => $_username]);
        /// End Retrieve user

        // Check if the user exists !
        if (!$user) {
            return new JsonResponse([
                'user' =>  'Username doesnt exists'
            ],JsonResponse::HTTP_OK);
        }

        /// Start verification
        $encoder = $factory->getEncoder($user);
        $salt = $user->getSalt();

        if(!$encoder->isPasswordValid($user->getPassword(), $_password, $salt)) {
            return new JsonResponse([
                'user' =>  'Username or Password not valid.'
            ],JsonResponse::HTTP_OK);
        }
        /// End Verification

        /**
         * LOGIN USER
         */
        $this->toLogin($request, $user);

        return new JsonResponse([
            'user' => $user->getJSON()
        ],JsonResponse::HTTP_OK);

    }

    /**
     * @Rest\Get("/checkUsername")
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @SWG\Tag(name="Security")
     *
     * @SWG\Parameter(
     *     name="username",
     *     in="query",
     *     type="string",
     *     description="User username"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user"
     * )
     */
    public function checkUsernameAction(Request $request)
    {
        $_username = $request->get('username');

        $user = $this->getDoctrine()->getRepository(User::class)
            ->findOneBy(['username' => $_username]);

        if ($user) {
            return new JsonResponse([
                'message' => 'Username is find'
            ],JsonResponse::HTTP_OK);
        }

        return new JsonResponse([
            'message' => 'Username is free'
        ],JsonResponse::HTTP_OK);
    }

    /**
     * @Rest\Get("/getUser")
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @SWG\Tag(name="Security")
     *
     * @SWG\Parameter(
     *     name="token",
     *     in="query",
     *     type="string",
     *     description="User authToken"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user"
     * )
     */
    public function getUserAction(Request $request)
    {
        $user = $this->getUser();

        // todo проверка по токену и логин пользователя

        if ($user) {
            return new JsonResponse([
                'user' => $user->getJSON()
            ],JsonResponse::HTTP_OK);
        }

        return new JsonResponse([
            'message' => 'Username is free'
        ],JsonResponse::HTTP_OK);
    }

    /**
     * @Rest\Post("/registerWithEmail")
     *
     * @param Request $request
     * @return JsonResponse
     *
     * @SWG\Tag(name="Security")
     *
     * @SWG\Parameter(
     *     name="username",
     *     in="query",
     *     type="string",
     *     description="User username"
     * )
     * @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     type="string",
     *     description="The field used to order rewards"
     * )
     *
     * @SWG\Response(
     *     response=200,
     *     description="Returns the rewards of an user"
     * )
     */
    public function registerWithEmailAction(Request $request)
    {
        //TODO валидация

        $_username = $request->get('username');
        $_email = $request->get('email');

        $user_manager = $this->get('fos_user.user_manager');

        $user = $user_manager->createUser();
        $user->setUsername($_username);
        $user->setEmail($_email);
        $user->genPassword();
        $user_manager->updateUser($user);

        /**
         * LOGIN USER
         */
        $this->toLogin($request, $user);

        return new JsonResponse([
            'user' => $user->getJSON()
        ],JsonResponse::HTTP_OK);
    }


    /**
     * LOGIN USER
     *
     * @param $request
     * @param User $user
     */
    private function toLogin($request, User $user)
    {
        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $this->get('security.token_storage')->setToken($token);

        $this->get('session')->set('_security_main', serialize($token));

        $event = new InteractiveLoginEvent($request, $token);
        $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
    }
}
