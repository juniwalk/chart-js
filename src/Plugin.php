<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

interface Plugin
{
	public function setChart(Chart $chart): self;
	public function getPath(): string;
	public function getName(): string;

	/**
	 * @return array<string, mixed>
	 */
	public function createConfig(): array;
}
