<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Traits;

use JuniWalk\Utils\Strings;
use Nette\Localization\Translator;
use Stringable;

trait Translatable
{
	protected ?Translator $translator;


	public function setTranslator(?Translator $translator): void
	{
		$this->translator = $translator;
	}


	public function getTranslator(): ?Translator
	{
		return $this->translator ?? null;
	}


	/**
	 * @param array<string, string> $params
	 */
	protected function translate(string|Stringable $value, array $params = []): string|Stringable
	{
		$value = (string) $value;

		if (!$this->translator instanceof Translator) {
			return $value;
		}

		if (!Strings::match($value, '/^([a-z][a-z0-9]+)\.([a-z][a-z0-9\._-]+)$/i')) {
			return $value;
		}

		return $this->translator->translate($value, $params);
	}
}
