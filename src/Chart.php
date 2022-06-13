<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\ChartJS\Attributes\Optionable;
use Nette\Application\UI\Control;
use Nette\Localization\ITranslator;

final class Chart extends Control
{
	use Optionable;

	/** @var string */
	private $title;

	/** @var string */
	private $color;

	/** @var Type */
	private $type;

	/** @var Dataset[] */
	private $datasets = [];

	/** @var ITranslator */
	private $translator;

	/** @var string[] */
	private $labels = [];


	/**
	 * @param  Type  $type
	 * @param  ITranslator  $translator
	 */
	public function __construct(string $type)
	{
		$this->type = $type;
	}


	/**
	 * @param  ITranslator  $translator
	 * @return void
	 */
	public function setTranslator(ITranslator  $translator): void
	{
		$this->translator = $translator;
	}


	/**
	 * @param  string|null  $title
	 * @return void
	 */
	public function setTitle(?string $title): void
	{
		$this->title = $title;
	}


	/**
	 * @return string|null
	 */
	public function getTitle(): ?string
	{
		return $this->title;
	}


	/**
	 * @param  Type  $type
	 * @return void
	 */
	// public function setType(Type $type): void
	public function setType(string $type): void
	{
		$this->type = $type;
	}


	/**
	 * @return Type
	 */
	public function getType()//: Type
	{
		return $this->type;
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
	 * @param  Dataset  $dataset
	 * @return void
	 */
	public function addDataset(Dataset $dataset): void
	{
		$this->datasets[] = $dataset;
	}


	/**
	 * @return void
	 */
	public function render(): void
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/templates/default.latte');
		$template->add('controlName', $this->getName());
		$template->add('config', $this->createConfig());
		$template->add('title', $this->title);
		$template->add('color', $this->color ?? 'secondary');
		$template->add('type', $this->type);

		// any onBeforeRender callbacks?

		$template->render();
	}


	/**
	 * @return string[]
	 */
	public function createConfig(): iterable
	{
		$translate = [$this->translator, 'translate'];
		$datasets = $labels = [];

		foreach ($this->datasets as $key => $dataset) {
			$datasets[$key] = $dataset->createConfig();
			$datasetLabels = $dataset->getLabels();

			if ($datasetLabels && sizeof($datasetLabels) > sizeof($labels)) {
				$labels = $datasetLabels;
			}

			if (isset($datasets[$key]['label'])) {
				$datasets[$key]['label'] = $translate($datasets[$key]['label']);
			}
		}

		foreach ($this->labels as $key => $value) {
			$labels[$key] = $translate($value);
		}

		return [
			'type' => $this->type,
			'data' => [
				'labels' => $labels,
				'datasets' => $datasets,
			],
			'options' => $this->getOptions(),
		];
	}
}
