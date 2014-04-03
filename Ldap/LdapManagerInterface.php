<?php
namespace Limitland\LdapBundle\Ldap;

interface LdapManagerInterface
{
    function __construct( LdapConnectionInterface $conn, array $params );
    
    function getUserByUsername( $username );
    
    function getRolesForUsername( $username );
    
}
