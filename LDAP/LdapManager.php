<?php

namespace Limitland\LdapBundle\LDAP;

class LdapManager implements LdapManagerInterface
{
    private $ldapConnection;
    private $authenticated;
    private $params;
    
    public function __construct(LdapConnectionInterface $conn, array $params)
    {
        $this->ldapConnection = $conn;
        $this->authenticated = false;
        $this->params = $params;
    }
    
    public function bind()
    {
        return $this->ldapConnection->bind();
    }
    
    public function getUserByUsername( $username )
    {
        $dn = $this->buildDnFromUsername( $username );
        $data = $this->ldapConnection->getEntry($dn);
        return $data;
    }
    
    public function getRolesForUsername( $username ) 
    {
        $dn = $this->buildDnFromUsername( $username );
        $roles = array();
        $groups = $this->ldapConnection->getGroups();
        foreach( $groups as $group ) { // loop the groups
            foreach( $group[$this->params['roles']['memberAttribute']] as $member ) { // loop the group members
                if( $member == $dn ) {
                    $groupname = $group[$this->params['roles']['nameAttribute']][0];
                    $groupname = 'ROLE_LDAP_'.strtoupper(str_replace(' ', '_', $groupname));
                    array_push($roles, $groupname);
                }
            }
        }
        return $roles;
    }
    
    public function buildDnFromUsername( $string )
    {
        $dn = $this->params['users']['nameAttribute'].'='.$string;
        $dn .= ','.$this->params['users']['baseDn'];
        return $dn;
    }
    
	
}
