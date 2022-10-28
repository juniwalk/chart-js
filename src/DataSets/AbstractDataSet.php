<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

use JuniWalk\ChartJS\DataSet;
use JuniWalk\ChartJS\Traits;

abstract class AbstractDataSet implements DataSet
{
	use Traits\Optionable;


	public function getAverage(): float
	{
		return 0;
	}


	public function createConfig(): array
	{
		return array_merge($this->getOptions(), [
			'data' => $this->fetchData(),
		]);
	}


	abstract protected function fetchData(): array;
}
