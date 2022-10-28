<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Traits;

use JuniWalk\Utils\Arrays;

trait Optionable
{
	protected array $options = [];


	public function setOption(string $key, mixed $value): void
	{
		$this->options[$key] = $value;
	}


	public function setOptions(array $options): void
	{
		$this->options = $options;
	}


	public function getOption(string $key): mixed
	{
		return $this->options[$key] ?? null;
	}


	public function getOptions(): array
	{
		return Arrays::unflatten($this->options);
	}
}
