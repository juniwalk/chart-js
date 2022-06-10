<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\Utils\Arrays;
use Nette\Application\UI\Control;

final class Chart extends Control
{
	/** @var Type */
	private $type;

	/** @var string[] */
	private $labels = [];

	/** @var Dataset */
	private $datasets = [];

	/** @var string[] */
	private $options = [];


	/**
	 * @param  Type  $type
	 * @param  string[]  $options
	 */
	public function __construct(string $type, iterable $options = [])
	{
		$this->type = $type;
		$this->options = $options;
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
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function setOption(string $key, $value): void
	{
		$this->options[$key] = $value;
	}


	/**
	 * @param  string  $key
	 * @return mixed
	 */
	public function getOption(string $key)//: mixed
	{
		return $this->options[$key] ?? null;
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
		$template->add('type', $this->type);

		$template->add('title', 'This is my first chart!');
		$template->add('color', 'primary');

		// any onBeforeRender callbacks?

		$template->render();
	}


	/**
	 * @return string[]
	 */
	public function createConfig(): iterable
	{
		$datasets = [];

		foreach ($this->datasets as $key => $dataset) {
			$datasets[$key] = $dataset->createConfig();
		}

		return [
			'type' => $this->type,
			'data' => [
				'labels' => $this->labels,
				'datasets' => $datasets,
			],
			'options' => Arrays::unflatten($this->options),
		];
	}
}
