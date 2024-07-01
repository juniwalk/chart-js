<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Plugins;

use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\Options;
use JuniWalk\ChartJS\Plugin;
use JuniWalk\ChartJS\Traits;
use JuniWalk\Utils\Format;

abstract class AbstractPlugin implements Plugin, Options
{
	use Traits\Optionable;

	protected Chart $chart;


	public function setChart(Chart $chart): void
	{
		$this->chart = $chart;
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
