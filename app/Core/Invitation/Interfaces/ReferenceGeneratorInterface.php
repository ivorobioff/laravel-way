<?php
namespace RealEstate\Core\Invitation\Interfaces;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface ReferenceGeneratorInterface
{
	/**
	 * @return string
	 */
	public function generate();
}