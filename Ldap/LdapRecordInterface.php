<?php
namespace Limitland\LdapBundle\Ldap;

interface LdapRecordInterface
{
    function __construct( $data );
    function getSingleAttribute( $key );
    function getFirstAttribute( $key );
    function getNthAttribute( $key, $n );
}
