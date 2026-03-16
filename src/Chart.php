<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\ChartJS\Enums\Type;
use JuniWalk\ChartJS\Traits\Options;
use JuniWalk\ChartJS\Traits\Translation;
use JuniWalk\Components\Actions\LinkProvider;
use JuniWalk\Components\Actions\Traits\Actions;
use JuniWalk\Components\Actions\Traits\Links;
use JuniWalk\Utils\Arrays;
use JuniWalk\Utils\Enums\Color;
use JuniWalk\Utils\Interfaces\EventHandler;
use JuniWalk\Utils\Json;
use JuniWalk\Utils\Traits\Events;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\DefaultTemplate;

/**
 * @phpstan-import-type DataStructure from DataSource
 */
final class Chart extends Control implements OptionHandler, EventHandler, LinkProvider
{
	use Actions, Events, Options, Links, Translation;

	protected DataSource $dataSource;
	protected Color $color;
	protected ?string $title = null;
	protected int|float $height = 300;

	/** @var array<string, Plugin> */
	protected array $plugins = [];


	/**
	 * @param array<string, mixed> $options
	 */
	public function __construct(
		protected Type $type,
		array $options = [],
	) {
		$this->dataSource = new DataSource;
		$this->setOptions($options);
		$this->watch('render');
	}


	public function setTitle(?string $title): void
	{
		$this->title = $title;
	}


	public function getTitle(): ?string
	{
		return $this->title;
	}


	public function setColor(Color $color): void
	{
		$this->color = $color;
	}


	public function getColor(): Color
	{
		return $this->color ?? Color::Secondary;
	}


	public function setHeight(int|float $height): void
	{
		$this->height = $height;
	}


	public function getHeight(): int|float
	{
		return $this->height;
	}


	public function setType(Type $type): void
	{
		$this->type = $type;
	}


	public function getType(): Type
	{
		return $this->type;
	}


	public function setDataSource(DataSource $dataSource): void
	{
		$this->dataSource = $dataSource;
	}


	public function getDataSource(): DataSource
	{
		return $this->dataSource;
	}


	public function getDataSet(string|int|float $name): ?DataSet
	{
		return $this->dataSource->getDataSet($name);
	}


	/**
	 * @param array<string> $labels
	 */
	public function setLabels(array $labels): void
	{
		$this->dataSource->setLabels($labels);
	}


	public function setDataSet(string|int|float $key, DataSet $dataSet): void
	{
		$this->dataSource->setDataSet($key, $dataSet);
	}


	public function addAverage(DataSet $dataSet, bool $isShowLabelOnHover = false, ?callable $callback = null): Plugin
	{
		$plugin = new Plugins\AveragePlugin($dataSet, $callback);
		$plugin->setLabelOnHover($isShowLabelOnHover);
		return $this->addPlugin($plugin);
	}


	public function addPlugin(Plugin $plugin): Plugin
	{
		$slug = $plugin->getPath().'.'.$plugin->getName();
		return $this->plugins[$slug] = $plugin->setChart($this);
	}


	public function render(): void
	{
		/** @var DefaultTemplate */
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/templates/default.latte');
		$template->getLatte()->addFilter('json', fn($x) => Json::encode($x, Json::PRETTY));

		$this->trigger('render', $this, $template);

		$template->setParameters([
			'controlName' => $this->getName(),
			'actions' => $this->getActions(),
			'config' => $this->createConfig(),
			'color' => $this->getColor(),
			'height' => $this->height,
			'title' => $this->title,
			'type' => $this->type,
		]);

		$template->render();
	}


	/**
	 * @return array{type: string, data: DataStructure, options: array<string, mixed>}
	 */
	public function createConfig(): array
	{
		$this->dataSource->setTranslator($this->translator);
		$options = $this->getOptions();

		foreach ($this->plugins as $path => $plugin) {
			$options[$path] = $plugin->createConfig();
		}

		return [
			'type' => $this->type->value,
			'data' => $this->dataSource->createConfig(),
			'options' => Arrays::unflatten($options),
		];
	}
}
