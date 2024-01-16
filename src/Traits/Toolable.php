<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Traits;

use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\Tool;
use JuniWalk\ChartJS\Tools;

trait Toolable
{
	protected Chart $chart;
	protected array $tools = [];


	public function addTool(Tool $tool): Tool
	{
		return $this->tools[] = $tool;
	}


	public function addLinkTool(string $href, string $name, array $params = []): Tool
	{
		$tool = new Tools\LinkTool($this->chart ?? $this);
		$tool->setLabel($name);
		$tool->setHref($href);
		$tool->setParams($params);

		return $this->addTool($tool);
	}


	public function addDropdownTool(string $name): Tool
	{
		$tool = new Tools\DropdownTool($this->chart ?? $this);
		$tool->setLabel($name);

		return $this->addTool($tool);
	}


	public function addGroupTool(): Tool
	{
		$tool = new Tools\GroupTool($this->chart ?? $this);

		return $this->addTool($tool);
	}
}
