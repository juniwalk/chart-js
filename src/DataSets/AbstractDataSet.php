<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

use Closure;
use JuniWalk\ChartJS\DataSet;
use JuniWalk\ChartJS\OptionHandler;
use JuniWalk\ChartJS\Traits\Options;

/**
 * @phpstan-import-type KeyValuePairs from DataSet
 */
abstract class AbstractDataSet implements DataSet, OptionHandler
{
	use Options;

	protected Closure $averageCallback;


	public function setAverageCallback(Closure $callback): void
	{
		$this->averageCallback = $callback;
	}


	public function getAverage(): float
	{
		$callback = $this->averageCallback ?? fn(self $dataSet): float => 0;
		return $callback($this);
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
