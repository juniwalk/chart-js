<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\DataSets;

use Closure;
use JuniWalk\ChartJS\DataSet;

/**
 * @phpstan-import-type KeyValuePairs from DataSet
 */
class CallbackDataSet extends AbstractDataSet
{
	public function __construct(
		string $label,
		protected Closure $callback,
	) {
		$this->setOption('label', $label);
	}


	/**
	 * @return KeyValuePairs
	 */
	protected function fetchData(): array
	{
		return ($this->callback)();
	}
}
