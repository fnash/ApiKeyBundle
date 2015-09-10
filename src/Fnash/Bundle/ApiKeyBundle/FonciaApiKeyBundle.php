<?php

namespace Fnash\ApiKeyBundle;

use Fnash\ApiKeyBundle\DependencyInjection\Security\Factory\ApiKeyFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class FnashApiKeyBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new ApiKeyFactory());
    }
}
