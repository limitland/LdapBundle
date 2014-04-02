<?php

namespace Limitland\LdapBundle\Ldap;

use Zend\Ldap\Ldap;

class LdapConnection implements LdapConnectionInterface
{
    private $params;
    private $ldap;

    public function __construct(array $params)
    {
        $this->params = $params;
        $this->ldap = false;
    }
    
    public function connect()
    {
        // Initialize the Zend Ldap Module.
        $this->ldap = new Ldap($this->params['client'])
                or die( "Error connecting to host ".$this->params['client']['host'].":".$this->params['client']['port']."." );
    }
    
    public function bind()
    {
        if( ! $this->ldap ) {
            $this->connect();
        }
        if( $this->ldap ) {
            $this->ldap->bind();
            return true;
        }
        return false;
    }
    
    public function getEntry( $dn )
    {
        $data = $this->ldap->getEntry($dn);
        if( empty($data) ) $data = false;
        return $data;
    }
    
    public function getGroups()
    {
        $result = $this->ldap->search($this->params['roles']['filter'], $this->params['roles']['baseDn']);
        return $result;
    }
}
