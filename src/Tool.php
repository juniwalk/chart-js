<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\Utils\Html;

interface Tool
{
	public function render(): Html;
}
