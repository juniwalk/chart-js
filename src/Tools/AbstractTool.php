<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Tools;

use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\Tool;
use Nette\Utils\Html;

abstract class AbstractTool implements Tool
{
	/** @var Chart */
	protected $chart;

	/** @var string */
	protected $label;

	/** @var string */
	protected $icon;

	/** @var bool */
	protected $isActive = false;

	/** @var string[] */
	protected $attributes = [
		'class' => ['btn', 'btn-sm', 'btn-secondary'],
	];


	/**
	 * @param Chart  $chart
	 */
	final public function __construct(Chart $chart)
	{
		$this->chart = $chart;
	}


	/**
	 * @param  string|null  $label
	 * @return void
	 */
	public function setLabel(?string $label): void
	{
		$this->label = $label;
	}


	/**
	 * @return string|null
	 */
	public function getLabel(): ?string
	{
		return $this->label;
	}


	/**
	 * @param  string|null  $icon
	 * @return void
	 */
	public function setIcon(?string $icon): void
	{
		$this->icon = $icon ?: null;
	}


	/**
	 * @param  string|null  $icon
	 * @return void
	 */
	public function getIcon(): ?string
	{
		return $this->icon;
	}


	/**
	 * @param  string  $class
	 * @return void
	 */
	public function setClass(string $class): void
	{
		$this->attributes['class'] = $class;
	}


	/**
	 * @param  string  $class
	 * @return void
	 */
	public function addClass(string $class): void
	{
		$this->attributes['class'][] = $class;
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
	 * @return bool
	 */
	public function isActive(): bool
	{
		return $this->isActive;
	}


	/**
	 * @return Html
	 */
	protected function createButton(): Html
	{
		$translator = $this->chart->getTranslator();
		$el = Html::el('a', $this->attributes);

		if ($this->icon) {
			$icon = Html::el('i')->setClass($this->icon);
			$el->setHtml($icon)->addText(' ');
		}

		if ($this->isActive) {
			$el->addClass('active');
		}

		$el->addText($translator->translate($this->label));
		return $el;
	}
}
