<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use Nette\Localization\Translator;
use Nette\Utils\Strings;

class DataSource
{
	/** @var string[] */
	protected $labels = [];

	/** @var DataSet[] */
	protected $dataSets = [];

	/** @var Translator */
	protected $translator;


	/**
	 * @param  Translator|null  $translator
	 * @return void
	 */
	public function setTranslator(?Translator $translator): void
	{
		$this->translator = $translator;
	}


	/**
	 * @param  string[]  $labels
	 * @return void
	 */
	public function setLabels(iterable $labels): void
	{
		$this->labels = $labels;
	}


	/**
	 * @param  string  $name
	 * @param  DataSet  $dataSet
	 * @return void
	 */
	public function setDataSet(string $name, DataSet $dataSet): void
	{
		$this->dataSets[$name] = $dataSet;
	}


	/**
	 * @param  int|string  $key
	 * @return DataSet|null
	 */
	public function getDataset(int|string $key): ?DataSet
	{
		return $this->dataSets[$key] ?? null;
	}


	/**
	 * @return string[]
	 */
	public function createConfig(): iterable
	{
		$config = ['labels' => [],'datasets' => []];

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
	 * @param  string  $value
	 * @return string
	 */
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


	/**
	 * @param  string[]  $data
	 * @return string[]
	 */
	protected function parse(iterable $data): iterable
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
