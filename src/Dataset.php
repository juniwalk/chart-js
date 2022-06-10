<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS;

use JuniWalk\Utils\Arrays;

final class Dataset
{
	/** @var string[] */
	private $data = [];

	/** @var string[] */
	private $options = [];


	/**
	 * @param  string  $label
	 * @param  string[]  $data
	 */
	public function __construct(string $label, iterable $data)
	{
		$this->setOption('label', $label);
		$this->data = $data;
	}


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
	 * @param  string  $key
	 * @return mixed
	 */
	public function getOption(string $key)//: mixed
	{
		return $this->options[$key] ?? null;
	}


	/**
	 * @return string[]
	 */
	public function createConfig(): iterable
	{
		$options = Arrays::unflatten($this->options);

		return $options + [
			'data' => $this->data,
		];
	}
}
