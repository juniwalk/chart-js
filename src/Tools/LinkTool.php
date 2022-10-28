<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Tools;

use JuniWalk\Utils\Html;
use JuniWalk\Utils\Strings;
use Nette\Application\UI\Component;
use Nette\Application\UI\InvalidLinkException;

final class LinkTool extends AbstractTool
{
	protected string $href;
	protected array $params;
	protected bool $isNewTab = false;
	protected bool $isAjax = false;


	public function setHref(string $href): void
	{
		$this->href = $href;
	}


	public function setParams(array $params = []): void
	{
		$this->params = $params;
	}


	public function setAjax(bool $isAjax = true): void
	{
		$this->isAjax = $isAjax;
	}


	public function setNewTab(bool $isNewTab = true): void
	{
		$this->isNewTab = $isNewTab;
	}


	public function render(): Html
	{
		$el = $this->createButton();
		$el->setHref($this->createLink());

		if ($this->isAjax) {
			$el->addClass('ajax');
		}

		if ($this->isNewTab) {
			$el->setTarget('_blank');
		}

		return $el;
	}


	private function createLink(): string
	{
		$presenter = $this->chart->getPresenter();
		$component = $this->chart;

		if (strpos($this->href, ':') !== false) {
			return $presenter->link($this->href, $this->params);
		}

		for ($iteration = 0; $iteration < 10; $iteration++) {
			$component = $component->getParent();

			if (!$component instanceof Component) {
				break;
			}

			try {
				$link = $component->link($this->href, $this->params);

			} catch (InvalidLinkException $e) {
				continue;
			}

			if (Strings::match($link, '/^\#error\:/i')) {
				continue;
			}

			return $link;
		}

		throw new InvalidLinkException;
	}
}
