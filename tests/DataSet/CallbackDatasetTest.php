<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

use JuniWalk\ChartJS\DataSets\CallbackDataSet;
use JuniWalk\ChartJS\DataSource;
use Tester\Assert;
use Tester\TestCase;

require __DIR__.'/../bootstrap.php';

/**
 * @testCase
 */
final class CallbackDatasetTest extends TestCase
{
	public function setUp() {}
	public function tearDown() {}

	public function testDataSource(): void
	{
		$dataSet = new CallbackDataSet('Callback dataset', fn() => [5, 24]);

		$dataSource = new DataSource;
		$dataSource->setTranslator(getTranslator());
		$dataSource->setDataSet('callback', $dataSet);
		$dataSource->setLabels([
			'dev.label.label-a',
			'Label B',
		]);

		$config = $dataSource->createConfig();

		Assert::same([5,24], $config['datasets'][0]['data']);
		Assert::contains('Label A', $config['labels']);
		Assert::contains('Label B', $config['labels']);
	}
}

(new CallbackDatasetTest)->run();
