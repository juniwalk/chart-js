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

	/** @var string[] */
	private $labels = [];


	/**
	 * @return string[]
	 */
	public function getLabels(): iterable
	{
		return array_values($this->labels);
	}


	/**
	 * @return string[]
	 */
	public function createConfig(): iterable
	{
		$data = $this->parseData($this->fetchData());
		return array_merge($this->getOptions(), [
			'data' => $data,
		]);
	}


	/**
	 * @return string[]
	 */
	abstract protected function fetchData(): iterable;


	/**
	 * @param  string[]  $data
	 * @return string[]
	 */
	protected function parseData(iterable $data): iterable
	{
		$this->labels = $result = [];

		foreach ($data as $item) {
			if (!is_array($item)) {
				$result[] = $item;
				continue;
			}

			$this->labels[] = $item['key'];
			$result[] = $item['value'];
		}

		return $result;
	}
}
