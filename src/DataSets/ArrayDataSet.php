<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

final class ArrayDataSet extends AbstractDataSet
{
	/** @var string[] */
	private $data = [];


	/**
	 * @param  string  $label
	 * @param  string[]  $data
	 */
	public function __construct(string $label, iterable $data)
	{
		$this->setOption('label', $label);
		$this->data = $data;
	}


	/**
	 * @return string[]
	 */
	public function fetchData(): iterable
	{
		return $this->data;
	}
}
