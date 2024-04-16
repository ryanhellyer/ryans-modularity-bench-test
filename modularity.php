<?php
/**
 * Bench test with Modularity.
 */

declare(strict_types=1);

namespace RyansModularityBenchTest;


use Inpsyde\Modularity\Package;
use Inpsyde\Modularity\Properties\PluginProperties;

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

function init()
{
    $properties = PluginProperties::new(__FILE__);
    $package = Package::new($properties);

    // Register modules here
    $package->addModule(new BenchTestModule\BenchTestModule());

    $package->boot();
}

add_action('plugins_loaded', __NAMESPACE__ . '\\init');
