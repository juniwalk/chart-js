<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\ChartJS\Enums\Type;
use JuniWalk\ChartJS\Traits\Optionable;
use JuniWalk\ChartJS\Traits\Toolable;
use JuniWalk\Utils\Enums\Color;
use JuniWalk\Utils\Strings;
use Nette\Application\UI\Control;
use Nette\Localization\Translator;

final class Chart extends Control
{
	use Optionable;
	use Toolable;

	protected ?Translator $translator = null;
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


	public function setTranslator(?Translator $translator): void
	{
		$this->translator = $translator;
	}


	public function getTranslator(): ?Translator
	{
		return $this->translator;
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


	public function addAverage(DataSet $dataSet, callable $label = null): void
	{
		$name = Strings::webalize($dataSet->getOption('label'));
		$color = 'rgba(128, 128, 128, 0.8)';

		if (!$average = $dataSet->getAverage()) {
			return;
		}

		$annotation = [
			'type' => 'line',
			'value' => $average,
			'scaleID' => 'y',
			'borderColor' => $color,
			'borderDash' => [6, 6],
			'borderDashOffset' => 0,
			'borderWidth' => 2,
		];

		if (!is_null($label)) {
			$annotation['label'] = [
				'content' => $label($average),
				'backgroundColor' => $color,
				'position' => 'end',
				'display' => true,
			];
		}

		$this->setOption('plugins.annotation.annotations.'.$name, $annotation);
	}


	public function render(): void
	{
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/templates/default.latte');
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
		if ($this->translator instanceof Translator) {
			$this->dataSource->setTranslator($this->translator);
		}

		return [
			'type' => $this->type->value,
			'data' => $this->dataSource->createConfig(),
			'options' => $this->getOptions(),
		];
	}
}
