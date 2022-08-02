<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeleteAdditionalDocumentFactory extends AbstractAdditionalDocumentFactory
{
	/**
	 * @return Action
	 */
	protected function getAction()
	{
		return new Action(Action::DELETE_ADDITIONAL_DOCUMENT);
	}
}