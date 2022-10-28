<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Plugins;

use JuniWalk\ChartJS\DataSet;
use JuniWalk\ChartJS\Enums\Type;
use JuniWalk\Utils\Strings;

class AveragePlugin extends AnnotationPlugin
{
	protected readonly DataSet $dataSet;
	protected ?string $label = null;
	protected array $options = [
		'type' => null,
		'value' => null,
		'scaleID' => 'y',
		'borderColor' => 'rgba(128, 128, 128, 0.8)',
		'borderDash' => [6, 6],
		'borderDashOffset' => 0,
		'borderWidth' => 2,
	];


	public function __construct(DataSet $dataSet, string $label = null)
	{
		$this->dataSet = $dataSet;
		$this->label = $label;
	}


	public function getName(): ?string
	{
		return Strings::webalize($this->dataSet->getOption('label'));
	}


	public function createConfig(): array
	{
		if (!$average = $this->dataSet->getAverage()) {
			return [];
		}

		$this->setOption('type', Type::Line->value);
		$this->setOption('value', $average);

		if (is_null($this->label)) {
			return parent::createConfig();
		}

		$this->setOption('label', [
			'display' => true,
			'position' => 'end',
			'backgroundColor' => $this->getOption('borderColor'),
			'content' => $this->translate($this->label, [
				'average' => $average,
			]),
		]);

		return parent::createConfig();
	}
}
