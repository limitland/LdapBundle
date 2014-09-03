<?php
namespace Limitland\LdapBundle\Ldap;

interface LdapManagerInterface
{
    function __construct( LdapConnectionInterface $conn );
    
    function getRecordByUsername( $username );
    
    function getRolesForUsername( $username );
    
}
