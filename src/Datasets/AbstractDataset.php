<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Datasets;

use JuniWalk\ChartJS\Attributes\Optionable;
use JuniWalk\ChartJS\Dataset;

abstract class AbstractDataset implements Dataset
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
