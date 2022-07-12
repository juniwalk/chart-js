<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Attributes;

use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\Tool;
use JuniWalk\ChartJS\Tools;

trait Toolable
{
	/** @var Chart */
	protected $chart;

	/** @var Tool[] */
	protected $tools = [];


	/**
	 * @param  Tool  $tool
	 * @return Tool
	 */
	public function addTool(Tool $tool): Tool
	{
		return $this->tools[] = $tool;
	}


	/**
	 * @param  string  $href
	 * @param  string  $name
	 * @param  string[]  $params
	 * @return LinkTool
	 */
	public function addLinkTool(string $href, string $name, iterable $params = []): Tool
	{
		$tool = new Tools\LinkTool($this->chart ?: $this);
		$tool->setLabel($name);
		$tool->setHref($href);
		$tool->setParams($params);

		return $this->addTool($tool);
	}


	/**
	 * @return DropdownTool
	 */
	public function addDropdownTool(string $name): Tool
	{
		$tool = new Tools\DropdownTool($this->chart ?: $this);
		$tool->setLabel($name);

		return $this->addTool($tool);
	}


	/**
	 * @return GroupTool
	 */
	public function addGroupTool(): Tool
	{
		$tool = new Tools\GroupTool($this->chart ?: $this);

		return $this->addTool($tool);
	}
}
