<?php

namespace Limitland\LdapBundle\LDAP;

interface LdapManagerInterface
{
  function __construct(LdapConnectionInterface $conn, array $params);
}
