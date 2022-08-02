<?php
namespace RealEstate\Api\Document\V2_0\Support;

use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Document\Interfaces\DocumentPreferenceInterface;
use RealEstate\Support\Shortcut;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UrlEncodedCalculatedProperty
{
	/**
	 * @var DocumentPreferenceInterface
	 */
	private $preference;

	/**
	 * @param DocumentPreferenceInterface $preference
	 */
    public function __construct(DocumentPreferenceInterface $preference)
    {
        $this->preference = $preference;
    }

    /**
     * @param Document $document
     * @return string
     */
    public function __invoke(Document $document)
    {
		return Shortcut::extractUrlFromDocument($document, $this->preference);
    }
}