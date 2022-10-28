<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

class ArrayDataSet extends AbstractDataSet
{
	protected array $data = [];


	public function __construct(string $label, array $data)
	{
		$this->setOption('label', $label);
		$this->data = $data;
	}


	public function getAverage(): float
	{
		return array_sum($this->data) / sizeof($this->data);
	}


	protected function fetchData(): array
	{
		return $this->data;
	}
}
