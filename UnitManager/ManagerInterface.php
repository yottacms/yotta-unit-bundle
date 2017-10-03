<?php 

namespace YottaCms\Bundle\YottaUnitBundle\UnitManager;

/**
 * Interface to be implemented by admin unit manager. 
 */
interface ManagerInterface
{
    /**
     * Add new unit for admin
     * @param UnitInterface $unit
     * @param int             $priority
     */
    public function add(UnitInterface $unit, int $priority = null);
    
    /**
     * Get unit object by class name
     * @param  mixed $unitName
     * @return UnitInterface
     */
    public function get(string $unitName): ?UnitInterface;
    
    /**
     * List all registred units
     * @return array
     */
    public function list(): array;
}
