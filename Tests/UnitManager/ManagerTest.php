<?php 

namespace YottaCms\Bundle\YottaUnitBundle\Test\UnitManager;

use PHPUnit\Framework\TestCase;
use YottaCms\Bundle\YottaUnitBundle\UnitManager\Manager;

class ManagerTest extends TestCase
{
    /** @var UnitManager */
    protected $unitManager;
    
    protected function setUp()
    {
        parent::setUp();
        $this->unitManager = new Manager();
    }
    
    protected function tearDown()
    {
        parent::tearDown();
        $this->unitManager = null;
    }
    
    public function testAdd()
    {
        $unit = $this->getUnitMock();
        $this->unitManager->add($unit);
        $listUnits = $this->unitManager->list();
        
        $this->assertTrue(end($listUnits)->unit === $unit);
        
        // check double insertion
        $this->unitManager->add($unit);
        $listUnits2 = $this->unitManager->list();
        $this->assertTrue($listUnits === $listUnits2);
    }
    
    public function testGet()
    {
        $unit = $this->getUnitMock();
        $this->unitManager->add($unit);
        
        $this->assertTrue($this->unitManager->get(get_class($unit)) === $unit);
    }
    
    public function testList()
    {
        $unit = $this->getUnitMock();
        $this->unitManager->add($unit);
        $listUnits = $this->unitManager->list();
        
        $this->assertTrue(sizeof($listUnits) == 1);
    }
    
    /**
     * @expectedException Error
     */
    public function testUnitInterface()
    {
        $unit = new stdClass();
        $this->unitManager->add($unit);
    }
    
    protected function getUnitMock()
    {
        $definition = $this->getMockBuilder('YottaCms\Bundle\YottaUnitBundle\UnitManager\UnitInterface')->getMock();
        return $definition;
    }
}
