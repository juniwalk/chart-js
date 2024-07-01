<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2024
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

interface OptionHandler
{
	public function setOption(string $key, mixed $value): void;
	public function getOption(string $key): mixed;

	/**
	 * @param array<string, mixed> $options
	 */
	public function setOptions(array $options): void;

	/**
	 * @return array<string, mixed>
	 */
	public function getOptions(): array;
}
