Limitland/LdapBundle
====================


This bundle provides User authentication from an LDAP database using the ZendFramework 2 LDAP module. 
Also User Roles are applied from the LDAP database using the groupOfNames Objectclass. 

The Zend Framework 2 LDAP module is capable of escaping and encoding the LDAP attributes according to RFC 1179 and 2253, it can handle TLS and SSL sessions and implements a lot of other useful features. 

This bundle ist tested with the following versions: 
- php: 5.4
- symfony2: 2.3
- zend_ldap: 2.3


Installation
------------

### Dependencies

This bundle depends on the [Zend Framework 2](http://framework.zend.com/) (ZF2) LDAP component. The component is installed using the dependency management tool [Composer](http://getcomposer.org/). Packages are provided by the Zend packages repository at [packages.zendframework.com](https://packages.zendframework.com/). The ZF2 LDAP component requires the [php_ldap](http://www.php.net/manual/en/book.ldap.php) module.


### Bundle installation

Add the following line to the require section of your comoser.json file: 

	"require": {
	    ...
        "zendframework/zend-ldap": "2.3.*",
        "limitland/ldap-bundle": "dev-master"
    },


Run composer update to install the bundles:

	$ php composer.phar update


Add the following line in app/AppKernel.php to register the bundle: 

	$bundles = array(
		...
        new Limitland\LdapBundle\LimitlandLdapBundle(),
    );

	
Appendix
--------


Thanks to the authors of other LdapBundles I have found online:

opensky/LdapBundle by opensky
https://github.com/opensky/LdapBundle

FR3DLdapBundle by Maks3w:
https://github.com/Maks3w/FR3DLdapBundle


