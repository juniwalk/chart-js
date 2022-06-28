<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Tools;

use JuniWalk\ChartJS\Attributes\Linkable;
use JuniWalk\ChartJS\Chart;
use Nette\Utils\Html;

final class LinkTool extends AbstractTool
{
	use Linkable;

	/** @var bool */
	protected $isActive = false;


	/**
	 * @param Chart  $chart
	 * @param string  $href
	 * @param string  $label
	 * @param string[]  $params
	 */
	public function __construct(Chart $chart, string $href, string $label, iterable $params = [])
	{
		$this->chart = $chart;
		$this->label = $label;
		$this->href = $href;
		$this->params = $params;
	}


	/**
	 * @param  bool  $isActive
	 * @return void
	 */
	public function setActive(bool $isActive): void
	{
		$this->isActive = $isActive;
	}


	/**
	 * @return Html
	 */
	public function render(): Html
	{
		$link = $this->createLink($this->chart, $this->href, $this->params);

		$el = Html::el('a');
		$el->setHref($link);
		$el->addClass($this->class);

		if ($this->isAjax) {
			$el->addClass('ajax');
		}

		if ($this->isActive) {
			$el->addClass('active');
		}

		if ($this->isNewTab) {
			$el->setTarget('_blank');
		}

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
