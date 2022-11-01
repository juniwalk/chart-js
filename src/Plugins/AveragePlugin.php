<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Plugins;

use Closure;
use JuniWalk\ChartJS\DataSet;
use JuniWalk\ChartJS\Enums\Type;
use JuniWalk\Utils\Json;
use JuniWalk\Utils\Strings;

class AveragePlugin extends AnnotationPlugin
{
	protected readonly DataSet $dataSet;
	protected ?Closure $callback = null;
	protected bool $isLabelOnHover = false;
	protected array $options = [
		'type' => null,
		'value' => null,
		'scaleID' => 'y',
		'borderColor' => 'rgba(0, 0, 0, 0.75)',
		'borderDash' => [6, 6],
		'borderDashOffset' => 0,
		'borderWidth' => 1.5,
	];


	public function __construct(DataSet $dataSet, callable $callback = null)
	{
		$this->callback = Closure::fromCallable($callback);
		$this->dataSet = $dataSet;
	}


	public function getName(): ?string
	{
		return Strings::webalize($this->dataSet->getOption('label'));
	}


	public function setLabelOnHover(bool $isLabelOnHover = false): void
	{
		$this->isLabelOnHover = $isLabelOnHover;
	}


	public function isLabelOnHover(): bool
	{
		return $this->isLabelOnHover;
	}


	public function createConfig(): array
	{
		if (!$average = $this->dataSet->getAverage()) {
			return [];
		}

		$this->setOption('borderColor', $this->dataSet->getOption('backgroundColor'));
		$this->setOption('type', Type::Line->value);
		$this->setOption('value', $average);

		if ($this->callback instanceof Closure) {
			$this->setOption('label', [
				'display' => !$this->isLabelOnHover,
				'position' => 'end',
				'backgroundColor' => 'rgba(0, 0, 0, 0.75)',
				'content' => $this->callback->call($this, $average),
			]);
		}

		if ($this->callback instanceof Closure && $this->isLabelOnHover) {
			$this->setOption('enter', Json::literal(<<<JS
				function(ctx, event) {
					ctx.element.label.options.display = true;
					return true;
				}
				JS));

			$this->setOption('leave', Json::literal(<<<JS
				function(ctx, event) {
					ctx.element.label.options.display = false;
					return true;
				}
				JS));
		}

		return parent::createConfig();
	}
}
