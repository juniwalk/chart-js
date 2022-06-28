<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use Nette\Utils\Html;

interface Tool
{
	/**
	 * @return Html
	 */
	public function render(): Html;
}
