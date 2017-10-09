<?php

namespace YottaCms\Bundle\YottaUnitBundle\Tests\DependencyInjection\Compiler;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use YottaCms\Bundle\YottaUnitBundle\DependencyInjection\Compiler\UnitManagerPass;

class UnitManagerPassTest extends TestCase
{
    /**
     * Tests that yotta unit not implementing UnitInterface
     * trigger an exception.
     *
     * @expectedException \InvalidArgumentException
     */
    public function testYottaUnitWithoutInterface()
    {
        // one service, not implementing any interface
        $services = array(
            'my_yotta_unit' => array(0 => array()),
        );

        $definition = $this->getMockBuilder('Symfony\Component\DependencyInjection\Definition')->getMock();
        $definition->expects($this->atLeastOnce())
            ->method('getClass')
            ->will($this->returnValue('stdClass'));

        $builder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')->setMethods(array('has', 'findTaggedServiceIds', 'findDefinition', 'getDefinition'))->getMock();
        $builder->expects($this->any())
            ->method('has')
            ->will($this->returnValue(true));

        $builder->expects($this->atLeastOnce())
            ->method('findTaggedServiceIds')
            ->will($this->returnValue($services));

        $builder->expects($this->atLeastOnce())
            ->method('findDefinition')
            ->will($this->returnValue($definition));

        $builder->expects($this->atLeastOnce())
            ->method('getDefinition')
            ->will($this->returnValue($definition));

        $registerListenersPass = new UnitManagerPass();
        $registerListenersPass->process($builder);
    }
    
    /**
     * Tests that yotta unit implementing UnitInterface
     * trigger an exception.
     */
    public function testYottaUnitValid()
    {
        // one service, not implementing any interface
        $services = array(
            'my_yotta_unit' => array(0 => array()),
        );

        $definition = $this->getMockBuilder('Symfony\Component\DependencyInjection\Definition')->getMock();
        $definition->expects($this->atLeastOnce())
            ->method('getClass')
            ->will($this->returnValue('YottaCms\Bundle\YottaUnitBundle\Tests\DependencyInjection\Compiler\UnitService'));

        $builder = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerBuilder')->setMethods(array('has', 'findTaggedServiceIds', 'findDefinition', 'getDefinition'))->getMock();
        $builder->expects($this->any())
            ->method('has')
            ->will($this->returnValue(true));

        $builder->expects($this->atLeastOnce())
            ->method('findTaggedServiceIds')
            ->will($this->returnValue($services));

        $builder->expects($this->atLeastOnce())
            ->method('findDefinition')
            ->will($this->returnValue($definition));

        $builder->expects($this->atLeastOnce())
            ->method('getDefinition')
            ->will($this->returnValue($definition));

        $registerListenersPass = new UnitManagerPass();
        $registerListenersPass->process($builder);
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage The service "foo" tagged "yotta.unit" must not be abstract.
     */
    public function testYottaUnitAbstract()
    {
        $container = new ContainerBuilder();
        $container->register('foo', 'stdClass')->setAbstract(true)->addTag('yotta.unit', array());
        $container->register('yotta.unit_manager', 'stdClass');

        $registerListenersPass = new UnitManagerPass();
        $registerListenersPass->process($container);
    }
    
    public function testYottaUnitResolvableClassName()
    {
        $container = new ContainerBuilder();

        $container->setParameter('unit_test.class', 'YottaCms\Bundle\YottaUnitBundle\Tests\DependencyInjection\Compiler\UnitService');
        $container->register('foo', '%unit_test.class%')->addTag('yotta.unit', array());
        $container->register('yotta.unit_manager', 'stdClass');

        $registerListenersPass = new UnitManagerPass();
        $registerListenersPass->process($container);

        $definition = $container->getDefinition('yotta.unit_manager');
        $expectedCalls = array(
            array(
                'add',
                array(new Reference('foo'), null)
            ),
        );
        $this->assertEquals($expectedCalls, $definition->getMethodCalls());
    }
    
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage You have requested a non-existent parameter "unit_test.class"
     */
    public function testYottaUnitUnresolvableClassName()
    {
        $container = new ContainerBuilder();
        $container->register('foo', '%unit_test.class%')->addTag('yotta.unit', array());
        $container->register('yotta.unit_manager', 'stdClass');

        $registerListenersPass = new UnitManagerPass();
        $registerListenersPass->process($container);
    }
}

class UnitService implements \YottaCms\Bundle\YottaUnitBundle\UnitManager\UnitInterface
{
    public function getName(): string
    {
        return 'test-unit-serive';
    }
    
    public function getDescription(): ?string
    {
        return 'test-unit-serive-description';
    }
    
    public function getConfig(): array
    {
        return array();
    }
    
    public function getEntryPoint(): ?string
    {
        return null;
    }

    public function getType(): string
    {
        return 'bundle';
    }
}
