<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use function Sodium\add;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;

class EmailNotificationService
{
    /**
     * @var \Swift_Mailer
     */
    protected $mailer;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * EmailNotificationService constructor.
     * @var \Symfony\Component\Templating\EngineInterface
     * @param \Swift_Mailer $mailer
     */
    protected $templating;

    /**
     * @var
     */
    protected $headMail;

    public function __construct(\Swift_Mailer $mailer, EntityManager $em, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->templating = $templating;
    }

    /**
     * @param $email
     * @param $params
     * @return bool
     */
    public function sendInvite($email, $params)
    {
        $this->headMail = 'Приглашение в систему';

        $message = (new \Swift_Message($this->headMail))
            ->setFrom('mail@reznikovk.ru')
            ->setTo($email)
            ->setBody(
                $this->templating->render('@App/email/invite.html.twig', $params),
                'text/html'
            );

        try {
            $this->mailer->send($message);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}
