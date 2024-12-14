<?php

namespace Webapi\Core;
class Container {
    private $instances = [];
    public function build(string $class){
        $reflection = new \ReflectionClass($class);
        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return new $class;
        }

        $parameters = $constructor->getParameters();
        $dependencies = [];

        foreach ($parameters as $parameter) {
            $type = $parameter->getType();
            $dependencies[] = $this->build($type->getName());
          
        }
        $this->instances[$class] = $reflection->newInstanceArgs($dependencies);
        return $reflection->newInstanceArgs($dependencies);
    }

    public function getInstances(): void {
        print_r ($this->instances);
    }

}

?>