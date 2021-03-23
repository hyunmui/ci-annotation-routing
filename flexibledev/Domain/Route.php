<?php

namespace FlexibleDev\Domain;

/**
 * @Annotations
 * @Target({"CLASS","METHOD"})
 * @package FlexibleDev\Domain
 */
final class Route
{
	/**
	 * Route rule
	 * 
	 * @Required
	 * @var string
	 */
	public $rule;
}
