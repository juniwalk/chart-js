<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

use Closure;

class CallbackDataSet extends AbstractDataSet
{
	public function __construct(
		string $label,
		protected Closure $callback,
	) {
		$this->setOption('label', $label);
	}


	/**
	 * @return array<array{key: string, value: int|float}>
	 */
	protected function fetchData(): array
	{
		return ($this->callback)();
	}
}
