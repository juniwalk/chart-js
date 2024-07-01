<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Plugins;

use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\OptionHandler;
use JuniWalk\ChartJS\Plugin;
use JuniWalk\ChartJS\Traits\Options;
use JuniWalk\Utils\Format;

abstract class AbstractPlugin implements Plugin, OptionHandler
{
	use Options;

	protected Chart $chart;


	public function setChart(Chart $chart): self
	{
		$this->chart = $chart;
		return $this;
	}


	public function getName(): string
	{
		return Format::className($this, suffix: 'Plugin');
	}


	/**
	 * @return array<string, mixed>
	 */
	public function createConfig(): array
	{
		return $this->getOptions();
	}
}
