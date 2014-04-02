<?php

namespace Limitland\LdapBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class LimitlandLdapBundle extends Bundle
{
    public function boot()
    {
        if (!function_exists('ldap_connect')) {
            throw new \Exception("The module php-ldap is not installed.");
        }
    }
}
