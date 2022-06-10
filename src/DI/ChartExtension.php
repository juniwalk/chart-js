<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DI;

use JuniWalk\ChartJS\ChartFactory;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

final class ChartExtension extends CompilerExtension
{
	/**
	 * @return Schema
	 */
	public function getConfigSchema(): Schema
	{
		return Expect::structure([])->otherItems()
			->castTo('array');
	}


	/**
	 * @return void
	 */
	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		$factory = $builder->addFactoryDefinition($this->prefix('chart'))
			->setClass(ChartFactory::class, []);
		$factory->getResultDefinition()->addSetup('setOptions', [$config]);
	}
}
