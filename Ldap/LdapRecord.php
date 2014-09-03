<?php

namespace Limitland\LdapBundle\Ldap;

/**
 * Class LdapManager
 *
 */
class LdapRecord implements LdapRecordInterface
{
    private $data;

    public function __construct( $data )
    {
        $this->data = $data;
        return $this;
    }

    public function getSingleAttribute( $key )
    {
        if( isset($this->data[$key]) ) {
            return $this->data[$key];
        }
        return null;
    }

    public function getFirstAttribute( $key )
    {
        if( isset($this->data[$key][0]) ) {
            return $this->data[$key][0];
        }
        return null;
    }

    public function getNthAttribute( $key, $n )
    {
        if( isset($this->data[$key][$n]) ) {
            return $this->data[$key][$n];
        }
        return null;
    }
}