<?php

namespace Limitland\LdapBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ldap');
        
        $rootNode
            ->children()
                ->append($this->addClientNode())
                ->append($this->addUserNode())
                ->append($this->addRoleNode())
            ->end()
        ;
    
        return $treeBuilder;
    }
    
    private function addClientNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('client');
    
        $node
            ->isRequired()
            ->children()
                ->scalarNode('host')->defaultValue('127.0.0.1')->end()
                ->scalarNode('port')->defaultValue(389)->end()
                ->scalarNode('useSsl')->defaultValue(false)->end()
                ->scalarNode('username')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('password')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('bindRequiresDn')->defaultValue(false)->end()
                ->scalarNode('baseDn')->isRequired()->cannotBeEmpty()->end()
            ->end()
        ;
    
        return $node;
    }
    
    private function addUserNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('users');
    
        $node
            ->isRequired()
            ->children()
                ->scalarNode('baseDn')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('filter')->defaultValue('(*)')->end()
                ->scalarNode('nameAttribute')->defaultValue('uid')->end()
            ->end()
        ;
    
        return $node;
    }
    
    private function addRoleNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('roles');
    
        $node
            ->children()
                ->scalarNode('baseDn')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('filter')->defaultValue('(*)')->end()
                ->scalarNode('nameAttribute')->defaultValue('cn')->end()
                ->scalarNode('memberAttribute')->defaultValue('member')->end()
            ->end()
        ;
    
        return $node;
    }
}
