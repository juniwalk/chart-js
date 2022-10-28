<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Plugins;

use JuniWalk\ChartJS\Plugin;
use JuniWalk\ChartJS\Traits;

abstract class AbstractPlugin implements Plugin
{
	use Traits\Optionable;
	use Traits\Translatable;

	protected readonly string $path;


	public function getPath(): string
	{
		return $this->path;
	}


	public function getName(): ?string
	{
		return null;
	}


	public function createConfig(): array
	{
		return $this->getOptions();
	}
}
