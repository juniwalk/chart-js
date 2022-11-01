<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Traits;

use JuniWalk\ChartJS\DataSet;
use JuniWalk\ChartJS\Plugin;
use JuniWalk\ChartJS\Plugins;

trait Optionable
{
	protected array $plugins = [];


	public function addPlugin(Plugin $plugin): Plugin
	{
		$path = $plugin->getPath();
	
		if ($name = $plugin->getName()) {
			$path .= '.'.$name;
		}
	
		return $this->plugins[$path] = $plugin;
	}


	public function addAverage(DataSet $dataSet, bool $isShowLabelOnHover = false, callable $callback = null): Plugin
	{
		$plugin = new Plugins\AveragePlugin($dataSet, $callback);
		$plugin->setLabelOnHover($isShowLabelOnHover);
		return $this->addPlugin($plugin);
	}
}
