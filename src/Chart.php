<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\ChartJS\Enums\Type;
use JuniWalk\ChartJS\Traits;
use JuniWalk\Utils\Enums\Color;
use JuniWalk\Utils\Arrays;
use JuniWalk\Utils\Json;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\DefaultTemplate;

final class Chart extends Control implements Options
{
	use Traits\Optionable;
	use Traits\Translatable;

	protected DataSource $dataSource;
	protected Type $type;
	protected ?Color $color = null;
	protected ?string $title = null;

	/** @var array<string, Plugin> */
	protected array $plugins = [];


	/**
	 * @param array<string, mixed> $options
	 */
	public function __construct(Type $type, array $options = [])
	{
		$this->dataSource = new DataSource;
		$this->options = $options;
		$this->type = $type;
	}


	public function setTitle(?string $title): void
	{
		$this->title = $title;
	}


	public function getTitle(): ?string
	{
		return $this->title;
	}


	public function setColor(?Color $color): void
	{
		$this->color = $color;
	}


	public function getColor(): ?Color
	{
		return $this->color;
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


	/**
	 * @param array<string> $labels
	 */
	public function setLabels(array $labels): void
	{
		$this->dataSource->setLabels($labels);
	}


	public function setDataSet(string $key, DataSet $dataSet): void
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
		$plugin->setChart($this);
		$path = $plugin->getPath();
		$name = $plugin->getName();
	
		return $this->plugins[$path.'.'.$name] = $plugin;
	}


	public function render(): void
	{
		/** @var DefaultTemplate */
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/templates/default.latte');
		$template->getLatte()->addFilter('json', fn($x) => Json::encode($x, Json::PRETTY));

		$template->setParameters([
			'controlName' => $this->getName(),
			'config' => $this->createConfig(),
			'title' => $this->title,
			'color' => $this->color ?? Color::Secondary,
			'type' => $this->type,
		]);

		// any onBeforeRender callbacks?

		$template->render();
	}


	/**
	 * @return array{type: string, data: array<string, mixed>, options: array<string, mixed>}
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
