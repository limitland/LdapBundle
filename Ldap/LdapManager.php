<?php

namespace Limitland\LdapBundle\Ldap;

/**
 * Class LdapManager
 * 
 */
class LdapManager implements LdapManagerInterface
{
    private $ldapConnection;
    private $params;
    
    /**
     * Initialize the manager.
     * 
     * @param LdapConnectionInterface $conn
     * @param array $params
     */
    public function __construct(LdapConnectionInterface $conn)
    {
        $this->ldapConnection = $conn;
        $this->params = $conn->getParameters();
    }
    
    /**
     * A Helper function to bind to the server.
     */
    public function bind( $username = null, $password = null)
    {
        return $this->ldapConnection->bind( $username, $password );
    }
    
    /**
     * Get an LDAP user by username.
     * 
     * (non-PHPdoc)
     * @see \Limitland\LdapBundle\Ldap\LdapManagerInterface::getUserByUsername()
     */
    public function getRecordByUsername( $username )
    {
        $dn = $this->buildDnFromUsername( $username );
        $data = $this->ldapConnection->getEntry($dn);
        return $data;
    }
    
    /**
     * Get the roles for a username. 
     * 
     * (non-PHPdoc)
     * @see \Limitland\LdapBundle\Ldap\LdapManagerInterface::getRolesForUsername()
     */
    public function getRolesForUsername( $username ) 
    {
        $dn = $this->buildDnFromUsername( $username );
        $roles = array();
        
        // ($(member=$dn)(objectClass=groupOfNames))
        $filter = '(&('.$this->params['roles']['memberAttribute'].'='.$dn.')'.$this->params['roles']['filter'].')';
        $basedn = $this->params['roles']['baseDn'];
        $groups = $this->ldapConnection->search( $filter, $basedn );
        
        foreach( $groups as $group ) { // loop the groups
            $groupname = $group[$this->params['roles']['nameAttribute']][0];
            $groupname = 'ROLE_LDAP_'.strtoupper(str_replace(' ', '_', $groupname));
            array_push($roles, $groupname);
        }
        
        return $roles;
    }
    
    /**
     * A helper function to return the dn for a username.
     * 
     * @param unknown $username
     * @return string
     */
    public function buildDnFromUsername( $username )
    {
        $dn = $this->params['users']['nameAttribute'].'='.$username;
        $dn .= ','.$this->params['users']['baseDn'];
        return $dn;
    }
    
	
}
