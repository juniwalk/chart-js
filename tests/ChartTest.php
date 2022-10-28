<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\DataSets\ArrayDataSet;
use JuniWalk\ChartJS\Enums\Type;
use Nette\Localization\Translator;
use Tester\Assert;

require __DIR__.'/../vendor/autoload.php';
Tester\Environment::setup();


$translator = new class implements Translator {
	private $messages = ['dev.label.label-a' => 'Label A',];
	public function translate($message, ... $params): string
	{
		return $this->messages[$message] ?? $message;
	}
};

$dataSet = new ArrayDataSet('Array dataset', [
	'dev.label.label-a' => 15,
	['key' => 'Label B', 'value' => 32],
]);


$chart = new Chart(Type::Bar, []);
$chart->setTitle('Test chart title');
$chart->setTranslator($translator);
$chart->setDataSet('array', $dataSet);

$config = $chart->createConfig();


Assert::same([15,32], $config['data']['datasets'][0]['data']);
Assert::contains('Label A', $config['data']['labels']);
Assert::contains('Label B', $config['data']['labels']);
