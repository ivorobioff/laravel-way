<?php
namespace RealEstate\Api\Session\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\User\Objects\Credentials;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class StoreProcessor extends BaseProcessor
{
	protected function configuration()
	{
		return [
			'username' => 'string',
			'password' => 'string',
			'autoLoginToken' => 'string'
		];
	}

    /**
     * @return Credentials
     */
    public function createCredentials()
    {
        return $this->populate(new Credentials());
    }

	/**
	 * @return string
	 */
	public function getAutoLoginToken()
	{
		return $this->get('autoLoginToken');
	}
} 