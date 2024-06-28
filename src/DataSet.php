<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

interface DataSet
{
	public function createConfig(): array;
	public function getAverage(): float;
}
