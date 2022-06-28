<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Attributes;

use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\Tool;
use JuniWalk\ChartJS\Tools\DropdownTool;
use JuniWalk\ChartJS\Tools\GroupTool;
use JuniWalk\ChartJS\Tools\LinkTool;

trait Toolable
{
	/** @var Chart */
	protected $chart;

	/** @var Tool[] */
	protected $tools = [];


	/**
	 * @param  Tool  $tool
	 * @return void
	 */
	public function addTool(Tool $tool): void
	{
		$this->tools[] = $tool;
	}


	/**
	 * @param  string  $href
	 * @param  string  $name
	 * @param  string[]  $params
	 * @return LinkTool
	 */
	public function addLinkTool(string $href, string $name, iterable $params = []): LinkTool
	{
		return $this->tools[] = new LinkTool($this->chart ?: $this, $href, $name, $params);
	}


	/**
	 * @return DropdownTool
	 */
	public function addDropdownTool(string $name): DropdownTool
	{
		return $this->tools[] = new DropdownTool($this->chart ?: $this, $name);
	}


	/**
	 * @return GroupTool
	 */
	public function addGroupTool(): GroupTool
	{
		return $this->tools[] = new GroupTool($this->chart ?: $this);
	}
}
