<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use Closure;
use JuniWalk\ChartJS\Enums\Box;
use JuniWalk\Utils\Enums\Color;
use Nette\Application\UI\Control;
use Nette\Bridges\ApplicationLatte\DefaultTemplate;

class SmallBox extends Control
{
	private Box $type = Box::Small;
	private ?string $subtitle = null;
	private ?string $unit = null;
	private ?string $icon = null;
	private ?Color $color = null;

	public function __construct(
		private string $title,
		private Closure $callback,
	) {
	}


	public function render(): void
	{
		$result = ($this->callback)($this);

		/** @var DefaultTemplate */
		$template = $this->createTemplate();
		$template->setFile(__DIR__.'/templates/'.$this->type->value.'.latte');

		$template->setParameters([
			'title' => $this->title,
			'subtitle' => $this->subtitle,
			'count' => $result,
			'unit' => $this->unit,
			'icon' => $this->icon,
			'color' => $this->color ?? Color::Secondary,

		]);

		$template->render();
	}


	public function type(Box $type): static
	{
		$this->type = $type;
		return $this;
	}


	public function title(string $title): static
	{
		$this->title = $title;
		return $this;
	}


	public function subtitle(?string $subtitle): static
	{
		$this->subtitle = $subtitle;
		return $this;
	}


	public function unit(?string $unit): static
	{
		$this->unit = $unit;
		return $this;
	}


	public function icon(string $icon): static
	{
		$this->icon = $icon;
		return $this;
	}


	public function color(Color $color): static
	{
		$this->color = $color;
		return $this;
	}
}
