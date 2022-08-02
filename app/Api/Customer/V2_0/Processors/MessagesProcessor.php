<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use RealEstate\Api\Appraisal\V2_0\Processors\AbstractMessagesProcessor;
use RealEstate\Core\Customer\Persistables\MessagePersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessagesProcessor extends AbstractMessagesProcessor
{
	protected function configuration()
	{
		$configuration = parent::configuration();

		$configuration['employee'] = 'string';

		return $configuration;
	}

	/**
	 * @return MessagePersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new MessagePersistable());
	}
}