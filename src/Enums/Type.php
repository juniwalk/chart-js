<?php declare(strict_types=1);

/**
 * @copyright Martin Procházka (c) 2022
 * @license   MIT License
 */

namespace JuniWalk\ChartJS\Enums;

enum Type: string
{
	case Bar = 'bar';
	case Bubble = 'bubble';
	case Doughnut = 'doughnut';
	case Line = 'line';
	case Pie = 'pie';
	case PolarArea = 'polarArea';
	case Radar = 'radar';
	case Scatter = 'scatter';
}
