<?php

namespace Limitland\LdapBundle\Ldap;

interface LdapConnectionInterface
{
    function __construct(array $params);
    function connect();
    function bind( $username, $password );
    function getEntry( $dn );
    function search( $filter, $basedn );
}
