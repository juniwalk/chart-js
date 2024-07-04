<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\ChartJS\Traits\Translation;
use Stringable;

/**
 * @phpstan-import-type KeyValuePairs from DataSet
 * @phpstan-type DataStructure array{
 * 		labels: array<string|Stringable>,
 * 		datasets: array<array{
 * 			data: array<float|int>,
 * 			label?: string|Stringable
 * 		}>
 * }
 */
class DataSource
{
	use Translation;

	/** @var array<string, DataSet> */
	protected array $dataSets = [];

	/** @var array<string|Stringable> */
	protected array $labels = [];


	/**
	 * @param array<string|Stringable> $labels
	 */
	public function setLabels(array $labels): void
	{
		$this->labels = $labels;
	}


	public function setDataSet(string $name, DataSet $dataSet): void
	{
		$this->dataSets[$name] = $dataSet;
	}


	public function getDataset(string $name): ?DataSet
	{
		return $this->dataSets[$name] ?? null;
	}


	/**
	 * @return DataStructure
	 */
	public function createConfig(): array
	{
		$config = [
			'labels' => [],
			'datasets' => [],
		];

		foreach ($this->dataSets as $dataSet) {
			$result = $dataSet->createConfig();
			$result['data'] = $this->parse($result['data']);

			if (isset($result['label'])) {
				$result['label'] = $this->translate($result['label']);
			}

			$config['datasets'][] = $result;
		}

		foreach ($this->labels as $value) {
			$config['labels'][] = $this->translate($value);
		}

		return $config;
	}


	/**
	 * @param  array<string, int|float>|KeyValuePairs $data
	 * @return array<int|float>
	 */
	protected function parse(array $data): array
	{
		$labels = $result = [];

		foreach ($data as $key => $item) switch (true) {
			case is_array($item):
				$result[] = $item['value'];
				$labels[] = $item['key'];
				break;

			default:
				$result[] = $item;
				$labels[] = $key;
				break;
		}

		if (empty($this->labels) || sizeof($labels) > sizeof($this->labels)) {
			$this->labels = $labels;
		}

		return $result;
	}
}
