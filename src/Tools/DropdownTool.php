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

final class DropdownTool extends AbstractTool
{
	use Toolable {
		addDropdownTool as protected;
		addGroupTool as protected;
	}


	/**
	 * @param Chart  $chart
	 * @param string  $label
	 */
	public function __construct(Chart $chart, string $label)
	{
		$this->chart = $chart;
		$this->label = $label;
	}


	/**
	 * @return void
	 */
	public function addSeparator(): void
	{
		$this->tools[] = new class implements Tool {
			public function render(): Html {
				return Html::el('div class="dropdown-divider"');
			}
		};
	}


	/**
	 * @return Html
	 */
	public function render(): Html
	{
		$el = Html::el('div class="btn-group mr-2"');
		$el->addHtml($btn = $this->renderButton());

		$dm = Html::el('div class="dropdown-menu"');
		$el->addhtml($dm);

		foreach ($this->tools as $tool) {
			if ($tool instanceof AbstractTool) {
				$tool->withClass('dropdown-item');
			}

			$dm->addHtml($tool->render());
		}

		return $el;
	}


	/**
	 * @return Html
	 */
	private function renderButton(): Html
	{
		$el = Html::el('a')->setClass($this->class)
			->addClass('dropdown-toggle')
			->data('toggle', 'dropdown');

		if ($this->icon) {
			$i = Html::el('i');
			$i->setClass($this->icon);

			$el->addHtml($i);
			$el->addText(' ');
		}

		$el->addText($this->label);
		return $el;
	}
}
