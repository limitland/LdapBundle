<?php 

namespace Limitland\LdapBundle\Security\User;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Limitland\LdapBundle\Ldap\LdapManagerInterface;

class LdapUserProvider implements UserProviderInterface
{
    /**
     * @var \Limitland\LdapBundle\Ldap\LdapManagerInterface
     */
    private $ldapManager;
    private $params;

    /**
     * Constructor
     *
     * @param \Limitland\LdapBundle\Ldap\LdapManagerInterface $ldapManager
     */
    public function __construct(LdapManagerInterface $ldapManager, array $params)
    {
        $this->ldapManager = $ldapManager;
        $this->params = $params;
    }
    
    /**
     * @inheritDoc
     */
    public function loadUserByUsername($username)
    {
        $success = $this->ldapManager->bind();
        
        if( ! $success ) {
            throw new AuthenticationException ('Cannot bind to the LDAP server.');
        }
        
        // The LDAP Manager returns an array on success, false if there is no user
        $ldif = $this->ldapManager->getUserByUsername( $username );

        if( $ldif ) {
            $username = $ldif[$this->params['users']['nameAttribute']][0];
            $password = $ldif['userpassword'][0];
            $roles = array('ROLE_LDAP');
            $ldaproles = $this->ldapManager->getRolesForUsername($username);
            $roles = array_merge($roles, $ldaproles);
            return new LdapUser( $username, $password, $roles );
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }
    
    /**
     * @inheritDoc
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof LdapUser) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }
    
    /**
     * @inheritDoc
     */
    public function supportsClass($class)
    {
        return $class === 'Limitland\LdapBundle\Security\User\LdapUser';
    }
}