<?php

namespace Limitland\LdapBundle\Ldap;

interface LdapManagerInterface
{
  function __construct(LdapConnectionInterface $conn, array $params);
}
