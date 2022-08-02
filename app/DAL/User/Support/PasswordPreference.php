<?php
namespace RealEstate\DAL\User\Support;

use RealEstate\Core\User\Interfaces\PasswordPreferenceInterface;
use Illuminate\Config\Repository as Config;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class PasswordPreference implements PasswordPreferenceInterface
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
	 * @return int
	 */
	public function getResetTokenLifetime()
	{
		return $this->config->get('app.password_reset_token_lifetime');
	}
}