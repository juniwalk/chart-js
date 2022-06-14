<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

use JuniWalk\ChartJS\Attributes\Optionable;
use JuniWalk\ChartJS\DataSet;

abstract class AbstractDataSet implements DataSet
{
	use Optionable;

	/**
	 * @return string[]
	 */
	public function createConfig(): iterable
	{
		return array_merge($this->getOptions(), [
			'data' => $this->fetchData(),
		]);
	}


	/**
	 * @return string[]
	 */
	abstract protected function fetchData(): iterable;
}
