<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Datasets;

final class CallbackDataset extends AbstractDataset
{
	/** @var callable */
	private $callback;


	/**
	 * @param  string  $label
	 * @param  string[]  $data
	 */
	public function __construct(string $label, callable $callback)
	{
		$this->setOption('label', $label);
		$this->callback = $callback;
	}


	/**
	 * @return string[]
	 */
	public function fetchData(): iterable
	{
		return ($this->callback)();
	}
}
