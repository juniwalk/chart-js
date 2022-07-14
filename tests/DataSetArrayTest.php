<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

use JuniWalk\ChartJS\DataSets\ArrayDataSet;
use JuniWalk\ChartJS\DataSource;
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


$dataSource = new DataSource;
$dataSource->setTranslator($translator);
$dataSource->setDataSet('array', $dataSet);
$config = $dataSource->createConfig();


Assert::same([15,32], $config['datasets'][0]['data']);
Assert::contains('Label A', $config['labels']);
Assert::contains('Label B', $config['labels']);
