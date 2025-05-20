<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

use JuniWalk\ChartJS\DataSet;

/**
 * @phpstan-import-type KeyValuePairs from DataSet
 */
class ArrayDataSet extends AbstractDataSet
{
	/**
	 * @param KeyValuePairs $data
	 */
	public function __construct(
		string|int|float $label,
		protected array $data = [],
	) {
		$this->setOption('label', $label);
	}


	public function getAverage(): float
	{
		return array_sum($this->data) / sizeof($this->data);
	}


	/**
	 * @return KeyValuePairs
	 */
	protected function fetchData(): array
	{
		return $this->data;
	}
}
