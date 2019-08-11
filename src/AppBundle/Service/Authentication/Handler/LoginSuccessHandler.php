<?php

namespace AppBundle\Service\Authentication\Handler;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{

    protected $router;
    protected $security;

    public function __construct(Router $router, AuthorizationChecker $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
//        $response = new RedirectResponse($this->router->generate('agent.main'));
//
//        if ($this->security->isGranted('ROLE_OPERATOR'))
//        {
//            $response = new RedirectResponse($this->router->generate('operator.main'));
//        }
//        if ($this->security->isGranted('ROLE_AGENT'))
//        {
//            $response = new RedirectResponse($this->router->generate('agent.main'));
//        }

        return new RedirectResponse($this->router->generate('all.main'));
    }
}
