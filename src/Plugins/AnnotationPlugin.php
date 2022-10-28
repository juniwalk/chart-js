<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Plugins;

class AnnotationPlugin extends AbstractPlugin
{
	public function getPath(): string
	{
		return 'plugins.annotation.annotations';
	}
}
