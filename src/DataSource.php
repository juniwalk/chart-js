<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\Utils\Strings;
use Nette\Localization\Translator;

class DataSource
{
	protected ?Translator $translator;
	protected array $dataSets = [];
	protected array $labels = [];


	public function setTranslator(?Translator $translator): void
	{
		$this->translator = $translator;
	}


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


	protected function translate(string $value): string
	{
		if (!$this->translator instanceof Translator) {
			return $value;
		}

		if (!Strings::match($value, '/^([a-z][a-z0-9]+)\.([a-z][a-z0-9\._-]+)$/i')) {
			return $value;
		}

		return $this->translator->translate($value);
	}


	protected function parse(array $data): array
	{
		$labels = $result = [];

		foreach ($data as $key => $item) switch (true) {
			case is_string($key) && is_scalar($item):
				$result[] = $item;
				$labels[] = $key;
				break;

			case is_array($item):
				$result[] = $item['value'];
				$labels[] = $item['key'];
				break;

			default:
				$result[] = $item;
				break;
		}

		if ($labels && sizeof($labels) > sizeof($this->labels)) {
			$this->labels = $labels;
		}

		return $result;
	}
}
