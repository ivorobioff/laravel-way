<?php
namespace RealEstate\Letter\Support;

use RealEstate\Core\Support\Letter\LetterPreferenceInterface;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class LetterPreference implements LetterPreferenceInterface
{
	/**
	 * @var Config
	 */
	private $config;

	/**
	 * @param Config $config
	 */
	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	/**
	 * @return string
	 */
	public function getNoReply()
	{
		return $this->config->get('mail.no_reply');
	}

	/**
	 * @return string
	 */
	public function getSignature()
	{
		return $this->config->get('mail.signature', 'The RealEstate Team');
	}
}