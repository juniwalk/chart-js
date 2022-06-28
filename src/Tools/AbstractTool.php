<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Tools;

use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\Tool;

abstract class AbstractTool implements Tool
{
	/** @var Chart */
	protected $chart;

	/** @var string */
	protected $label;

	/** @var string */
	protected $class = 'btn btn-sm btn-secondary';

	/** @var string */
	protected $icon;


	/**
	 * @param  string  $label
	 * @return static
	 */
	public function withLabel(string $label): self
	{
		$this->label = $label;
		return $this;
	}


	/**
	 * @param  string  $class
	 * @return static
	 */
	public function withClass(string $class): self
	{
		$this->class = $class;
		return $this;
	}


	/**
	 * @param  string|null  $icon
	 * @return static
	 */
	public function withIcon(?string $icon): self
	{
		$this->icon = $icon ?: null;
		return $this;
	}
}
