<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Tools;

use Nette\Application\UI\Component;
use Nette\Application\UI\InvalidLinkException;
use Nette\Utils\Html;
use Nette\Utils\Strings;

final class LinkTool extends AbstractTool
{
	/** @var string */
	protected $href;

	/** @var string[] */
	protected $params;

	/** @var bool */
	protected $isNewTab = false;

	/** @var bool */
	protected $isAjax = false;


	/**
	 * @param  string  $href
	 * @return void
	 */
	public function setHref(string $href): void
	{
		$this->href = $href;
	}


	/**
	 * @param  string[]  $params
	 * @return void
	 */
	public function setParams(iterable $params = []): void
	{
		$this->params = $params;
	}


	/**
	 * @param  bool  $isAjax
	 * @return void
	 */
	public function setAjax(bool $isAjax = true): void
	{
		$this->isAjax = $isAjax;
	}


	/**
	 * @param  bool  $isAjax
	 * @return void
	 */
	public function setNewTab(bool $isNewTab = true): void
	{
		$this->isNewTab = $isNewTab;
	}


	/**
	 * @return Html
	 */
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


	/**
	 * @return string
	 * @throws InvalidLinkException
	 */
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
