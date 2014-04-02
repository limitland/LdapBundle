<?php

namespace Limitland\LdapBundle\LDAP;

interface LdapConnectionInterface
{
    function __construct(array $params);
}
