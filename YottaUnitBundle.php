<?php

namespace YottaCms\Bundle\YottaUnitBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use YottaCms\Bundle\YottaUnitBundle\DependencyInjection\Compiler\UnitManagerPass;

class YottaUnitBundle extends Bundle
{
    
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new UnitManagerPass());
    }
    
}
