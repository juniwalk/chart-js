<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

use Nette\Localization\Translator;
use Tester\Environment;
use Tracy\Debugger;

if (@!include __DIR__.'/../vendor/autoload.php') {
	echo 'Install Nette Tester using `composer install`';
	exit(1);
}

Debugger::enable(Debugger::Development);
Environment::setup();

function getTranslator(): Translator
{
	return new class implements Translator
	{
		/** @var array<string, string> */
		private $messages = [
			'dev.label.label-a' => 'Label A',
		];

		/**
		 * @param array<string, mixed> $params
		 */
		public function translate(Stringable|string $message, ...$params): Stringable|string
		{
			return $this->messages[(string) $message] ?? $message;
		}
	};
}
