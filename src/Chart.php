<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\ChartJS\Attributes\Optionable;
use JuniWalk\ChartJS\Enums\Type;
use Nette\Application\UI\Control;
use Nette\Localization\ITranslator as Translator;

final class Chart extends Control
{
	use Optionable;

	/** @var string */
	private $title;

	/** @var string */
	private $color;

	/** @var Type */
	private $type;

	/** @var Datasource */
	private $datasource;

	/** @var Translator */
	private $translator;

	/** @var string[] */
	private $labels = [];


	/**
	 * @param  Type  $type
	 * @param  string[]  $options
	 */
	public function __construct(string $type, iterable $options = [])
	{
		$this->datasource = new Datasource;
		$this->options = $options;
		$this->type = $type;
	}


	/**
	 * @param  Translator  $translator
	 * @return void
	 */
	public function setTranslator(Translator $translator): void
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
	 * @param  Datasource  $datasource
	 * @return void
	 */
	public function setDatasource(Datasource $datasource): void
	{
		$this->datasource = $datasource;
	}


	/**
	 * @param  string  $key
	 * @param  Dataset  $dataset
	 * @return void
	 */
	public function setDataset(string $key, Dataset $dataset): void
	{
		$this->datasource->setDataset($key, $dataset);
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
		if ($this->translator instanceof Translator) {
			$this->datasource->setTranslator($this->translator);
		}

		return [
			'type' => $this->type,
			'data' => $this->datasource->createConfig(),
			'options' => $this->getOptions(),
		];
	}
}
