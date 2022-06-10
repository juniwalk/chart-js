<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Attributes;

use JuniWalk\Utils\Arrays;

trait Optionable
{
	/** @var string[] */
	private $options = [];


	/**
	 * @param  string  $key
	 * @param  mixed  $value
	 * @return void
	 */
	public function setOption(string $key, $value): void
	{
		$this->options[$key] = $value;
	}


	/**
	 * @param  mixed[]  $options
	 * @return void
	 */
	public function setOptions(iterable $options): void
	{
		$this->options = $options;
	}


	/**
	 * @param  string  $key
	 * @return mixed
	 */
	public function getOption(string $key)//: mixed
	{
		return $this->options[$key] ?? null;
	}


	/**
	 * @return mixed[]
	 */
	public function getOptions(): iterable
	{
		return Arrays::unflatten($this->options);
	}
}
