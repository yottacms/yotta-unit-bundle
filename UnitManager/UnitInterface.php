<?php 

namespace YottaCms\Bundle\YottaUnitBundle\UnitManager;

/**
 * Interface to be implemented by units for YottaCMS Bundle 
 */
interface UnitInterface
{
    /**
     * Get name unit
     * @return string
     */
    public function getName(): string;
    
    /**
     * Get description for unit
     * @return string
     */
    public function getDescription(): ?string;
    
    /**
     * Get configuration for unit
     * @return array
     */
    public function getConfig(): array;
    
    /**
     * Get entry point for unit
     * @return array
     */
    public function getEntryPoint(): ?string;
    
    /**
     * Get type
     * @return string   bundle | widget | system
     */
    public function getType(): string;
}
