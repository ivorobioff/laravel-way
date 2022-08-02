<?php
namespace RealEstate\Core\Support\Letter;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface LetterPreferenceInterface
{
	/**
	 * @return string
	 */
	public function getNoReply();

	/**
	 * @return string
	 */
	public function getSignature();
}