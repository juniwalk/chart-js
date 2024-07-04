<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\DataSets\ArrayDataSet;
use JuniWalk\ChartJS\Enums\Type;
use Tester\Assert;
use Tester\TestCase;

require __DIR__.'/../bootstrap.php';

/**
 * @testCase
 */
final class ChartTest extends TestCase
{
	public function setUp() {}
	public function tearDown() {}

	public function testCreateConfig(): void
	{
		$dataSet = new ArrayDataSet('Array dataset', [
			['key' => 'dev.label.label-a', 'value' => 15],
			['key' => 'Label B', 'value' => 32],
		]);

		$chart = new Chart(Type::Bar, []);
		$chart->setTitle('Test chart title');
		$chart->setTranslator(getTranslator());
		$chart->setDataSet('array', $dataSet);

		$config = $chart->createConfig();

		Assert::same([15,32], $config['data']['datasets'][0]['data']);
		Assert::contains('Label A', $config['data']['labels']);
		Assert::contains('Label B', $config['data']['labels']);
	}
}

(new ChartTest)->run();
