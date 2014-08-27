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


### Bundle configuration

Add the following lines to your app/routing.yml to enable the authentication and demo login dialog:

	limitland_ldap_auth:
    	resource: "@LimitlandLdapBundle/Resources/config/routing.yml"
    	prefix:   /
	
	limitland_ldap_login:
    	resource: "@LimitlandLdapBundle/Controller/"
    	type:     annotation
    	prefix:   /


And add the following lines to your app/security.yml:

	security:
	
	    encoders:
        	Limitland\LdapBundle\Security\User\LdapUser:
            	algorithm: plaintext
	
		providers:
        	ldap:
            	id: limitland_ldap.user_provider
	
	    firewalls:
	        login_firewall:
	            pattern: ^/login$
	            anonymous: ~
	        secured_area:
	            provider: ldap
	            pattern: ^/
	            form_login:
	                check_path: login_check
	                login_path: login
	                use_forward: false
	                always_use_default_target_path: false
	                default_target_path: /
	                target_path_parameter: _target_path
	                use_referer: true
	                failure_path: /login
	                failure_forward: false
	                username_parameter: _username
	                password_parameter: _password
	                csrf_parameter: _csrf_token
	                intention: authenticate
	                post_only: true
	                remember_me: false
	            logout:
	                path: /logout
	                target: /login
	                invalidate_session: true
	            anonymous: ~

	    access_control:
	        - { path: ^/login, roles: IS_AUTHENTICATED_ANONYMOUSLY }
	        - { path: ^/, roles: IS_AUTHENTICATED_FULLY }


Add the following lines to your app/config/config.yml and edit the values to match your LDAP installation:

	limitland_ldap:
	    client:
	        host:               "localhost"
	        port:               389
	        useSsl:             false
	        username:           "cn=admin,dc=limitland,dc=lan"
	        password:           "password"
	        bindRequiresDn:     false
	        baseDn:             "dc=limitland,dc=lan"
	    users:
	        baseDn:             "dc=limitland,dc=lan"
	        filter:             "(objectClass=person)"
	        nameAttribute:      "cn"
	    roles:
	        baseDn:             "dc=limitland,dc=lan"
	        filter:             "(objectClass=groupOfNames)"
	        nameAttribute:      "cn"
	        memberAttribute:    "member"



### Using the bundle

Use the bundle in your Controller like this:

    use Limitland\LdapBundle\Ldap\LdapConnection;
    use Limitland\LdapBundle\Ldap\LdapManager;
    
    $conn = new LdapConnection($config['limitland_ldap']);
    $manager = new LdapManager($conn);
    
    if( $user = $manager->getUserByUsername('demouser') ) {
        print_r($user);
    }


LDAP setup
----------

A guide to setting up your LDAP server ist not included, yet. It will follow in future versions of this bundle. However, there is a SETUP directory within the bundle, with some demo ldif records and a script that might be useful. 

	
Appendix
--------


Thanks to the authors of other LdapBundles I have found online:

opensky/LdapBundle by opensky
https://github.com/opensky/LdapBundle

FR3DLdapBundle by Maks3w:
https://github.com/Maks3w/FR3DLdapBundle


