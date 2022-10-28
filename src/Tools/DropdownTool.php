<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Tools;

use JuniWalk\ChartJS\Tool;
use JuniWalk\ChartJS\Traits;
use JuniWalk\Utils\Html;

final class DropdownTool extends AbstractTool
{
	use Traits\Toolable {
		addDropdownTool as protected;
		addGroupTool as protected;
	}


	public function addSeparator(): void
	{
		$this->tools[] = new class implements Tool {
			public function render(): Html {
				return Html::el('div class="dropdown-divider"');
			}
		};
	}


	public function render(): Html
	{
		$dropdownMenu = Html::el('div class="dropdown-menu"');
		$button = $this->createButton()
			->addClass('dropdown-toggle')
			->data('toggle', 'dropdown');

		foreach ($this->tools as $tool) {
			if ($tool instanceof AbstractTool) {
				$tool->addClass('dropdown-item');
			}

			$dropdownMenu->addHtml($tool->render());
		}

		$el = Html::el('div class="btn-group mr-2"');
		$el->addHtml($button)->addhtml($dropdownMenu);

		return $el;
	}
}
