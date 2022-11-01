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

final class Chart extends Control
{
	use Traits\Optionable;
	use Traits\Pluginable;
	use Traits\Translatable;
	use Traits\Toolable;

	protected DataSource $dataSource;
	protected Type $type;
	protected ?Color $color = null;
	protected ?string $title = null;


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


	public function setLabels(array $labels): void
	{
		$this->dataSource->setLabels($labels);
	}


	public function setDataSet(string $key, DataSet $dataSet): void
	{
		$this->dataSource->setDataSet($key, $dataSet);
	}


	public function render(): void
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/templates/default.latte');
		$template->getLatte()->addFilter('json', function(mixed $s): string {
			return Json::encode($s, Json::PRETTY);
		});

		$template->add('controlName', $this->getName());
		$template->add('config', $this->createConfig());
		$template->add('title', $this->title);
		$template->add('color', $this->color ?? Color::Secondary);
		$template->add('tools', $this->tools);
		$template->add('type', $this->type);

		// any onBeforeRender callbacks?

		$template->render();
	}


	public function createConfig(): array
	{
		$this->dataSource->setTranslator($this->translator);
		$options = $this->options;

		foreach ($this->plugins as $path => $plugin) {
			$plugin->setTranslator($this->translator);
			$options[$path] = $plugin->createConfig();
		}

		return [
			'type' => $this->type->value,
			'data' => $this->dataSource->createConfig(),
			'options' => Arrays::unflatten($options),
		];
	}
}
