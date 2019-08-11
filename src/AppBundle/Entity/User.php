<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Constants\UserRoles;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="phone", type="string", nullable=true)
     */
    protected $phone;

    /**
     * @ORM\Column(name="auth_token", type="string", nullable=true)
     */
    protected $authToken;

    public function __construct()
    {
        parent::__construct();
        $this->setEnabled(true);
    }

    public function setUsername($username)
    {
        $this->username = $username;

        if (!$this->getEmail()) {
            $this->setEmail($username);
        }

        return $this;
    }

    public function getStatus()
    {
        if ($this->hasRole(UserRoles::ROLE_USER)) {
            return 'USER';
        }
        else if ($this->hasRole(UserRoles::ROLE_ADMIN)) {
            return 'ADMIN';
        }

        return 'NULL';
    }

    public function getJSON()
    {
        return [
            'id' => $this->getId(),
            'username' => $this->getUsername(),
            'status' => $this->getStatus()
        ];
    }

    public function genPassword()
    {
        $hash = hash('sha256', uniqid(null, true));
        $this->setPassword($hash);
    }




    //GETTERS & SETTERS
    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getAuthToken()
    {
        return $this->authToken;
    }

    /**
     * @param mixed $authToken
     */
    public function setAuthToken($authToken)
    {
        $this->authToken = $authToken;
    }


}