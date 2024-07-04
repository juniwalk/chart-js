<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use Stringable;

/**
 * @phpstan-type KeyValuePairs array<array{key: string, value: int|float}>
 * @phpstan-type DataStructure array{data: array<string, int|float>|KeyValuePairs, label?: string|Stringable}
 */
interface DataSet extends OptionHandler
{
	public function getAverage(): float;

	/**
	 * @return DataStructure
	 */
	public function createConfig(): array;
}
