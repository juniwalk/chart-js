<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\ChartJS\Datasets\ArrayDataset;
use Nette\Localization\ITranslator as Translator;

class Datasource
{
	/** @var string[] */
	protected $labels = [];

	/** @var Dataset[] */
	protected $datasets = [];

	/** @var Translator */
	protected $translator;


	/**
	 * @param  Translator  $translator
	 * @return void
	 */
	public function setTranslator(Translator $translator): void
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
	 * @param  string  $label
	 * @param  mixed[]  $data
	 * @return Dataset
	 */
	public function setDataset(string $name, Dataset $dataset): Dataset
	{
		return $this->datasets[$name] = $dataset;
	}


	/**
	 * @param  int|string  $key
	 * @return Dataset|null
	 */
	public function getDataset(int|string $key): ?Dataset
	{
		return $this->datasets[$key] ?? null;
	}


	/**
	 * @return string[]
	 */
	public function createConfig(): iterable
	{
		$config = ['labels' => [],'datasets' => []];

		foreach ($this->datasets as $dataset) {
			$result = $dataset->createConfig();
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
