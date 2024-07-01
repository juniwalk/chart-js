<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

class ArrayDataSet extends AbstractDataSet
{
	/**
	 * @param array<array{key: string, value: int|float}> $data
	 */
	public function __construct(
		string $label,
		protected array $data = [],
	) {
		$this->setOption('label', $label);
	}


	public function getAverage(): float
	{
		return array_sum($this->data) / sizeof($this->data);
	}


	/**
	 * @return array<array{key: string, value: int|float}>
	 */
	protected function fetchData(): array
	{
		return $this->data;
	}
}
