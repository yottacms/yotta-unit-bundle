<?php

namespace YottaCms\Bundle\YottaUnitBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use YottaCms\Bundle\YottaUnitBundle\UnitManager\Manager;

/**
 * Adds services tagged yotta.unit as YottaCMS Unit.
 */
class UnitManagerPass implements CompilerPassInterface
{
    /**
     * @var string
     */
    protected $dispatcherService;

    /**
     * @var string
     */
    protected $unitTag;

    /**
     * Constructor.
     *
     * @param string $dispatcherService Service name of the event dispatcher in processed container
     * @param string $unitTag       Tag name used for unit manager
     */
    public function __construct($dispatcherService = 'yotta.unit_manager', $unitTag = 'yotta.unit')
    {
        $this->dispatcherService = $dispatcherService;
        $this->unitTag = $unitTag;
    }
    
    public function process(ContainerBuilder $container)
    {
        if (!$container->has($this->dispatcherService)) {
            return;
        }

        $definition = $container->findDefinition($this->dispatcherService);
        $taggedServices = $container->findTaggedServiceIds($this->unitTag, true);
        
        foreach ($taggedServices as $id => $tags) {
            foreach ($tags as $attributes) {
                
                $def = $container->getDefinition($id);
                $class = $container->getParameterBag()->resolveValue($def->getClass());
                $interface = 'YottaCms\Bundle\YottaUnitBundle\UnitManager\UnitInterface';

                if (!is_subclass_of($class, $interface)) {
                    if (!class_exists($class, false)) {
                        throw new InvalidArgumentException(sprintf('Class "%s" used for service "%s" cannot be found.', $class, $id));
                    }
                    throw new InvalidArgumentException(sprintf('Service "%s" must implement interface "%s".', $id, $interface));
                }
                
                $definition->addMethodCall('add', array(new Reference($id), $attributes["priority"] ?? null));
            }
        }
        
    }
}
