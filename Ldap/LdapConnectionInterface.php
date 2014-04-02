<?php

namespace Limitland\LdapBundle\Ldap;

interface LdapConnectionInterface
{
    function __construct(array $params);
}
