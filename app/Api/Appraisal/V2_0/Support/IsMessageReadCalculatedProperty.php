<?php
namespace RealEstate\Api\Appraisal\V2_0\Support;

use RealEstate\Core\Appraisal\Entities\Message;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class IsMessageReadCalculatedProperty
{
    /**
     * @var MessageReaderResolver
     */
    private $readerResolver;


	/**
     * @param MessageReaderResolver $readerResolver
	 */
	public function __construct(MessageReaderResolver $readerResolver)
	{
        $this->readerResolver = $readerResolver;
	}

    /**
     * @param Message $message
     * @return bool
     */
	public function __invoke(Message $message)
	{
		foreach ($message->getReaders() as $reader){
			if ($reader->getId() == $this->readerResolver->getReader()){
				return true;
			}
		}

		return false;
	}
}