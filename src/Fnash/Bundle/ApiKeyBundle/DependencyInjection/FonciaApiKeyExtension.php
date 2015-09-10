<?php

namespace Fnash\ApiKeyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class FnashApiKeyExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yml');
        $loader->load('admin.yml');

        $this->defineKeyExtractor($config, $container);
    }

    private function defineKeyExtractor(array $config, ContainerBuilder $container)
    {
        $container->setParameter('Fnash.api_key.parameter_name', $config['parameter_name']);
        $container->setAlias('Fnash.api_key.extractor', 'Fnash.api_key.extractor.'.$config['delivery']);
    }
}
