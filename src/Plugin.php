<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

interface Plugin
{
	public function getPath(): string;


	public function getName(): ?string;


	public function createConfig(): array;
}
