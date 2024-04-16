<?php

namespace RyansModularityBenchTest\BenchTestModule;

use Inpsyde\Modularity\Module\ExecutableModule;
use Psr\Container\ContainerInterface;
use Inpsyde\Modularity\Module\ModuleClassNameIdTrait;

class BenchTestModule implements ExecutableModule
{
    use ModuleClassNameIdTrait;

    public function run(ContainerInterface $container): bool
    {
        add_filter('init', '\ryansModularityBenchTest');

        return true;
    }
}
