<?php

namespace Limitland\LdapBundle\Security\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;

class LdapUser implements UserInterface, EquatableInterface
{
    private $username;
    private $password;
    private $roles;

    public function __construct( $username, $password, $roles )
    {
        $this->username = $username;
        $this->password = $password;
        $this->roles = $roles;
    }

    public function __toString()
    {
        return $this->username;
    }
    
    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return $this->roles;
    }
    
    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }
    
    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }
    
    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }
    
    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        $this->password = '';
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof LdapUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}