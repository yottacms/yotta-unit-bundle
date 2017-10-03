<?php 

namespace YottaCms\Bundle\YottaUnitBundle\UnitManager;

/**
 * Admin units manager
 */
class Manager implements ManagerInterface
{
    /**
     * List units
     * @var array
     */
    protected $units = [];

    /**
     * @inheritdoc
     */
    public function add(UnitInterface $unit, int $priority = null)
    {
        
        if (false == $this->get(get_class($unit))) {
        
            $unitStruct = new class{};
            $unitStruct->unit = $unit;
            $unitStruct->priority = $priority ?: sizeof($this->units);

            $this->units[] = $unitStruct;
            
            usort($this->units, function($a, $b) {
                return $a->priority <=> $b->priority;
            });
            
        }
        
        return true;
    }
    
    /**
     * @inheritdoc
     */
    public function get(string $unitName): ?UnitInterface
    {
        foreach ($this->units as $unitStruct) {
            if (get_class($unitStruct->unit) == $unitName) {
                return $unitStruct->unit;
            }
        }
        
        return null;
    }
    
    /**
     * @inheritdoc
     */
    public function list(): array
    {
        return $this->units;
    }
    
}
