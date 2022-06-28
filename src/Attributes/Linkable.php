<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Attributes;

use Nette\Application\UI\Control;
use Nette\Application\UI\Component;
use Nette\Application\UI\InvalidLinkException;
use Nette\Utils\Strings;

trait Linkable
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
	 * @param  Control  $control
	 * @param  string  $href
	 * @param  string[]  $params
	 * @return string
	 * @throws InvalidLinkException
	 */
	protected function createLink(Control $control, string $href, iterable $params): string
	{
		$presenter = $control->getPresenter();
		$component = $control;

		if (strpos($href, ':') !== false) {
			return $presenter->link($href, $params);
		}

		for ($iteration = 0; $iteration < 10; $iteration++) {
			$component = $component->getParent();

			if (!$component instanceof Component) {
				break;
				throw new InvalidLinkException;
			}

			try {
				$link = $component->link($href, $params);

			} catch (InvalidLinkException $e) {
				$link = false;
			}

			if (Strings::match($link, '/^\#error\:/i')) {
				continue;
			}

			return $link;
		}

		throw new InvalidLinkException;
	}
}
