<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Traits;

use JuniWalk\ChartJS\Options;	// ! Used for @phpstan
use JuniWalk\Utils\Arrays;

/**
 * @phpstan-require-implements Options
 */
trait Optionable
{
	/** @var array<string, mixed> */
	protected array $options = [];


	public function setOption(string $key, mixed $value): void
	{
		$this->options[$key] = $value;
	}


	/**
	 * @param array<string, mixed> $options
	 */
	public function setOptions(array $options): void
	{
		$this->options = $options;
	}


	public function getOption(string $key): mixed
	{
		return $this->options[$key] ?? null;
	}


	/**
	 * @return array<string, mixed>
	 */
	public function getOptions(): array
	{
		return Arrays::unflatten($this->options);
	}
}
