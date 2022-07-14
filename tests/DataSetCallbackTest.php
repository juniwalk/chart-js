<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

use JuniWalk\ChartJS\DataSets\CallbackDataSet;
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

$dataSet = new CallbackDataSet('Callback dataset', function() {
	return [5, 24];
});


$dataSource = new DataSource;
$dataSource->setTranslator($translator);
$dataSource->setDataSet('callback', $dataSet);
$dataSource->setLabels([
	'dev.label.label-a',
	'Label B',
]);
$config = $dataSource->createConfig();


Assert::same([5,24], $config['datasets'][0]['data']);
Assert::contains('Label A', $config['labels']);
Assert::contains('Label B', $config['labels']);
