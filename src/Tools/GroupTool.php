<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Tools;

use JuniWalk\ChartJS\Attributes\Toolable;
use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\Tool;
use Nette\Utils\Html;

final class GroupTool implements Tool
{
	use Toolable {
		addGroupTool as protected;
	}


	/**
	 * @param Chart  $chart
	 */
	public function __construct(Chart $chart)
	{
		$this->chart = $chart;
	}


	/**
	 * @return Html
	 */
	public function render(): Html
	{
		$el = Html::el('div class="btn-group"');

		foreach ($this->tools as $tool) {
			$el->addHtml($tool->render());
		}

		return $el;
	}
}
