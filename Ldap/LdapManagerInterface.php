<?php
namespace Limitland\LdapBundle\Ldap;

interface LdapManagerInterface
{
    function __construct( LdapConnectionInterface $conn );
    
    function getUserByUsername( $username );
    
    function getRolesForUsername( $username );
    
}
