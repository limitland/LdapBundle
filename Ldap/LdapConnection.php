<?php

namespace Limitland\LdapBundle\Ldap;

use Zend\Ldap\Ldap;

/**
 * Class LdapConnection
 *
 */
class LdapConnection implements LdapConnectionInterface
{
    private $params;
    private $ldap;

    /**
     * Initialize the connection.
     * 
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
        $this->ldap = false;
    }
    
    /**
     * Return the connection parameters.
     */
    public function getParameters()
    {
        return $this->params;
    }
    
    /**
     * Connect to the LDAP Server.
     */
    public function connect()
    {
        // Initialize the Zend Ldap Module.
        $this->ldap = new Ldap($this->params['client'])
                or die( "Error connecting to host ".$this->params['client']['host'].":".$this->params['client']['port']."." );
    }
    
    /**
     * Bind to the LDAP server instance.
     * 
     * @param unknown $username
     * @param unknown $password
     * @return boolean
     * 
     * (non-PHPdoc)
     * @see \Limitland\LdapBundle\Ldap\LdapConnectionInterface::bind()
     */
    public function bind($username = null, $password = null)
    {
        if( ! $this->ldap ) $this->connect();
        
        if( $this->ldap ) {
            if( empty($username) && empty($password) ) {
                // The Zend Framework will bind with the username and password from the connection configuration, 
                // see http://framework.zend.com/manual/2.3/en/modules/zend.ldap.introduction.html
                $this->ldap->bind();
            }
            else {
                $this->ldap->bind($username, $password);
            }
            return true;
        }
        return false;
    }
    
    /**
     * Return an LDAP object by dn or false.
     * 
     * (non-PHPdoc)
     * @see \Limitland\LdapBundle\Ldap\LdapConnectionInterface::getEntry()
     */
    public function getEntry( $dn )
    {
        if( ! $this->ldap ) $this->connect();
        
        $data = $this->ldap->getEntry($dn);
        if( empty($data) ) $data = false;
        return $data;
    }
    
    /**
     * Return a search result.
     * 
     * (non-PHPdoc)
     * @see \Limitland\LdapBundle\Ldap\LdapConnectionInterface::search()
     */
    public function search( $filter, $basedn )
    {
        if( ! $this->ldap ) $this->connect();
        
        return $this->ldap->search( $filter, $basedn );
    }
}