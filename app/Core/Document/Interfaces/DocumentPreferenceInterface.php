<?php
namespace RealEstate\Core\Document\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface DocumentPreferenceInterface
{
    /**
     * @return int
     */
    public function getLifetime();

	/**
	 * @return string
	 */
	public function getBaseUrl();
}