# YottaCMS unit manager
Пакетный менеджер бандлов для YottaCMS

## Installation
```Bash
composer require yottacms/yotta-unit-bundle
```
## Usage
```YAML
# app/config/services.yml
\UnitExample:
    arguments: ['@service_container']
    tags: 
        - { name: yotta.unit, priority: 300 }
```

## Recommendations

Настройку юнит-сервиса лучше всего делать следующим образом:

```YAML
# app/config/config.yml
yotta_unit:
    items:
        unit_example: 
            type: "bundle"      # widget | system
            name: "Unit Info"
            description: "Unit information"
            icon: "info" # optional
            version: "0.0.1"    # optional
            # if bundle | widget
            entry_point: "/info" # path to entry point
```        
```PHP    
// UnitExample.php
use Symfony\Component\DependencyInjection\ContainerInterface;
use YottaCms\Bundle\YottaUnitBundle\UnitManager\UnitInterface;

class UnitExample implements UnitInterface
{
    const PARAMETER_KEY = 'unit_example';
    
    protected $configUnit;
    
    public function __construct(ContainerInterface $container)
    {
        if (!isset($container->getParameter('yotta_unit.items')[self::PARAMETER_KEY])) {
            throw new \Exception('Parameters "' . self::PARAMETER_KEY . '" not found in yotta_unit.items');
        }
        
        $this->configUnit = $container->getParameter('yotta_unit.items')[self::PARAMETER_KEY];
    }
    
    /**
     * @inheritdoc
     */
    public function getName(): string 
    {
        return $this->configUnit['name'];
    }
    
    /**
     * @inheritdoc
     */
    public function getDescription(): ?string 
    {
        return $this->configUnit['description'];
    }
    
    /**
     * @inheritdoc
     */
    public function getEntryPoint(): ?string
    {
        return $this->configUnit['entry_point'];
    }
    
    /**
     * @inheritdoc
     */
    public function getConfig(): array
    {
        return $this->configUnit;
    }
    
    /**
     * @inheritdoc
     */
    public function getType(): string
    {
        return $this->configUnit['type'];
    }
}
```
