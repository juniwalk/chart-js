<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

use JuniWalk\ChartJS\DataSet;
use JuniWalk\ChartJS\Options;
use JuniWalk\ChartJS\Traits;

abstract class AbstractDataSet implements DataSet, Options
{
	use Traits\Optionable;


	public function getAverage(): float
	{
		return 0;
	}


	/**
	 * @return array<string, mixed>
	 */
	public function createConfig(): array
	{
		return array_merge($this->getOptions(), [
			'data' => $this->fetchData(),
		]);
	}


	/**
	 * @return array<array{key: string, value: int|float}>
	 */
	abstract protected function fetchData(): array;
}
