<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

use JuniWalk\ChartJS\DataSets\ArrayDataSet;
use JuniWalk\ChartJS\DataSets\CallbackDataSet;
use JuniWalk\ChartJS\DataSource;
use Tester\Assert;

require __DIR__.'/../vendor/autoload.php';
Tester\Environment::setup();


$dataSource = new DataSource;
$dataSource->setDataSet('array', new ArrayDataSet('Array dataset', [
	'Label A' => 15,
	['key' => 'Label B', 'value' => 32],
]));
$dataSource->setDataSet('callback', new CallbackDataSet('Callback dataset', function() {
	return [5, 24];
}));

$config = $dataSource->createConfig();


Assert::contains('Label A', $config['labels']);
Assert::same([15,32], $config['datasets'][0]['data']);
Assert::same([5,24], $config['datasets'][1]['data']);
