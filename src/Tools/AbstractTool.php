<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Tools;

use JuniWalk\ChartJS\Chart;
use JuniWalk\ChartJS\Tool;
use JuniWalk\Utils\Html;

abstract class AbstractTool implements Tool
{
	protected Chart $chart;
	protected ?string $label = null;
	protected ?string $icon = null;
	protected bool $isActive = false;
	protected array $attributes = [
		'class' => ['btn', 'btn-sm', 'btn-secondary'],
	];


	final public function __construct(Chart $chart)
	{
		$this->chart = $chart;
	}


	public function setLabel(?string $label): void
	{
		$this->label = $label;
	}


	public function getLabel(): ?string
	{
		return $this->label;
	}


	public function setIcon(?string $icon): void
	{
		$this->icon = $icon ?: null;
	}


	public function getIcon(): ?string
	{
		return $this->icon;
	}


	public function setClass(string $class): void
	{
		$this->attributes['class'] = $class;
	}


	public function addClass(string $class): void
	{
		$this->attributes['class'][] = $class;
	}


	public function setActive(bool $isActive): void
	{
		$this->isActive = $isActive;
	}


	public function isActive(): bool
	{
		return $this->isActive;
	}


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
