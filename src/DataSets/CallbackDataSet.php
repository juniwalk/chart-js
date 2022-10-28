<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

use Closure;

class CallbackDataSet extends AbstractDataSet
{
	protected Closure $callback;


	public function __construct(string $label, callable $callback)
	{
		$this->callback = Closure::fromCallable($callback);
		$this->setOption('label', $label);
	}


	protected function fetchData(): array
	{
		return ($this->callback)();
	}
}
