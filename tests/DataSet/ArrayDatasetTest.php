<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

use JuniWalk\ChartJS\DataSets\ArrayDataSet;
use JuniWalk\ChartJS\DataSource;
use Tester\Assert;
use Tester\TestCase;

require __DIR__.'/../bootstrap.php';

/**
 * @testCase
 */
final class ArrayDatasetTest extends TestCase
{
	public function setUp() {}
	public function tearDown() {}

	public function testDataSource(): void
	{
		$dataSet = new ArrayDataSet('Array dataset', [
			['key' => 'dev.label.label-a', 'value' => 15],
			['key' => 'Label B', 'value' => 32],
		]);

		$dataSource = new DataSource;
		$dataSource->setTranslator(getTranslator());
		$dataSource->setDataSet('array', $dataSet);

		$config = $dataSource->createConfig();

		Assert::same([15,32], $config['datasets'][0]['data']);
		Assert::contains('Label A', $config['labels']);
		Assert::contains('Label B', $config['labels']);
	}
}

(new ArrayDatasetTest)->run();
