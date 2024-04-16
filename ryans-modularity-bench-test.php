<?php
/**
 * Plugin Name: Ryans Modularity bench test.
 * Description: Tests how fast Modularity is in comparison to raw PHP.
 * Version: 1.0
 * Author: Ryan Hellyer <ryanhellyer@gmail.com>
 */

declare(strict_types=1);

$GLOBALS['startTime'] = microtime(true);

function ryansModularityBenchTest()
{
    $types = ['modularity', 'oldSchool'];
    foreach ( $types as $type) {
        if (! isset($_GET[$type])) {
            continue;
        }

        $endTime = microtime(true);
        $timeDifference = ($endTime - $GLOBALS['startTime']) * 1000000; // In micro-seconds.

        $key = $type . 'Test';
        $data = (array) get_option($key);
        $data[] = $timeDifference;
        update_option($key, $data);
    }

    $text = '';
    foreach ( $types as $type) {
        $data = (array) get_option($type . 'Test');
        $count = count($data);
        $sum = array_sum($data);
        $average[$type] = $sum / $count / 1000;


        $text .= esc_html($type) . ' average load time = ' . roundButShowTwoDP($average[$type]) . ' µs from ' . esc_html($count) . ' tests.<br>';
    }

    $text .= 'Difference = ' . roundButShowTwoDP(abs($average['modularity'] - $average['oldSchool'])) . ' µs, ' . roundButShowTwoDP(abs(100 - (100 * ($average['modularity'] / $average['oldSchool'])))) . '%.';

    die($text);
}

function roundButShowTwoDP($number) {
    return esc_html(number_format($number, 2, '.', ''));
}

if (isset($_GET['oldSchool'])) {
    require('old-school.php');
} else if (isset($_GET['modularity'])) {
    require('modularity.php');
} else if (isset($_GET['runTest'])) {
    require('run-test.php');
    die;
}