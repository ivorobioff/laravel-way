<?php
namespace RealEstate\Core\Appraisal\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use RealEstate\Core\Appraisal\Persistables\ContactPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UniqueContactType extends AbstractRule
{
	public function __construct()
	{
		$this->setIdentifier('unique');
		$this->setMessage('Contact types must be unique.');
	}

	/**
	 * @param array $contacts
	 * @return Error|null
	 */
	public function check($contacts)
	{
		$types = [];

		/**
		 * @var ContactPersistable[] $contacts
		 */
		foreach ($contacts as $contact){

			$type = $contact->getType()->value();

			if (in_array($type, $types)){
				return $this->getError();
			}

			$types[] = $type;
		}

		return null;
	}
}