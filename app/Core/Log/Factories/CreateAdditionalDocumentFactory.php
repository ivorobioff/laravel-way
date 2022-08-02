<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateAdditionalDocumentFactory extends AbstractAdditionalDocumentFactory
{
	/**
	 * @return Action
	 */
	protected function getAction()
	{
		return new Action(Action::CREATE_ADDITIONAL_DOCUMENT);
	}
}