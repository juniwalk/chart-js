<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

interface DataSet
{
	/**
	 * @return string[]
	 */
	public function createConfig(): iterable;
}
