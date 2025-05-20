<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

use JuniWalk\ChartJS\DataSet;
use JuniWalk\ChartJS\OptionHandler;
use JuniWalk\ChartJS\Traits\Options;

/**
 * @phpstan-import-type KeyValuePairs from DataSet
 */
abstract class AbstractDataSet implements DataSet, OptionHandler
{
	use Options;

	public function getAverage(): float
	{
		return 0;
	}


	/**
	 * @return array{data: KeyValuePairs}
	 */
	public function createConfig(): array
	{
		/** @var array{data: KeyValuePairs} */
		return array_merge($this->getOptions(), [
			'data' => $this->fetchData(),
		]);
	}


	/**
	 * @return KeyValuePairs
	 */
	abstract protected function fetchData(): array;
}
