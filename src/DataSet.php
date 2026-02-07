<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use Stringable;

/**
 * @phpstan-type KeyValuePairs array<string, int|float>|array<array{key: string, value: int|float}>
 */
interface DataSet extends OptionHandler
{
	public function getAverage(): float;

	/**
	 * @return array{data: KeyValuePairs, label?: string|int|float|Stringable}
	 */
	public function createConfig(): array;
}
