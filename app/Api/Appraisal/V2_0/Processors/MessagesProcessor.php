<?php
namespace RealEstate\Api\Appraisal\V2_0\Processors;

use RealEstate\Core\Appraisal\Persistables\MessagePersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessagesProcessor extends AbstractMessagesProcessor
{
	/**
	 * @return MessagePersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new MessagePersistable());
	}
}