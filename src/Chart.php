<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\ChartJS\Attributes\Optionable;
use JuniWalk\ChartJS\Attributes\Toolable;
use JuniWalk\ChartJS\Enums\Type;
use Nette\Application\UI\Control;
use Nette\Localization\Translator;

final class Chart extends Control
{
	use Optionable;
	use Toolable;

	/** @var Translator */
	protected $translator;

	/** @var DataSource */
	protected $dataSource;

	/** @var Type */
	protected $type;

	/** @var string */
	protected $title;

	/** @var string */
	protected $color;


	/**
	 * @param  Type  $type
	 * @param  string[]  $options
	 */
	public function __construct(string $type, iterable $options = [])
	{
		$this->dataSource = new DataSource;
		$this->options = $options;
		$this->type = $type;
	}


	/**
	 * @param  Translator|null  $translator
	 * @return void
	 */
	public function setTranslator(?Translator $translator): void
	{
		$this->translator = $translator;
	}


	/**
	 * @return Translator|null
	 */
	public function getTranslator(): ?Translator
	{
		return $this->translator;
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
	 * @param  string|null  $color
	 * @return void
	 */
	public function setColor(?string $color): void
	{
		$this->color = $color;
	}


	/**
	 * @return string|null
	 */
	public function getColor(): ?string
	{
		return $this->color;
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
	 * @param  DataSource  $dataSource
	 * @return void
	 */
	public function setDataSource(DataSource $dataSource): void
	{
		$this->dataSource = $dataSource;
	}


	/**
	 * @param  string[]  $labels
	 * @return void
	 */
	public function setLabels(iterable $labels): void
	{
		$this->dataSource->setLabels($labels);
	}


	/**
	 * @param  string  $key
	 * @param  DataSet  $dataSet
	 * @return void
	 */
	public function setDataSet(string $key, DataSet $dataSet): void
	{
		$this->dataSource->setDataSet($key, $dataSet);
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
		$template->add('tools', $this->tools);
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
			$this->dataSource->setTranslator($this->translator);
		}

		return [
			'type' => $this->type,
			'data' => $this->dataSource->createConfig(),
			'options' => $this->getOptions(),
		];
	}
}
