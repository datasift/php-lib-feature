<?php

use DataSift\Feature\FeatureManager;

require __DIR__ . '/../vendor/autoload.php';

$data = json_decode(file_get_contents(__DIR__ . '/data/test.json'), true);

$feature = new FeatureManager([
    'driver' => 'array',
    'data' => $data
]);

$key = isset($argv[1]) ? $argv[1] : 'test';
$value = $feature->isEnabled($key);

echo "[{$key}] is " . ($value ? "enabled" : "disabled") . "\n";
