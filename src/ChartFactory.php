<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2020
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\ChartJS\Enums\Type;

interface ChartFactory
{
	/**
	 * @param  Type  $type
	 * @return Chart
	 */
	// public function create(Type $type): Chart;
	public function create(string $type): Chart;
}
