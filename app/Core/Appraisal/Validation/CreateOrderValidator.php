<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\Binder;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateOrderValidator extends AbstractOrderValidator
{
	use AdditionalDocumentValidatorTrait;

	/**
	 * @param Binder $binder
	 */
	public function define(Binder $binder)
	{
		parent::define($binder);

		$this->defineAdditionalDocument($binder, $this->container, $this->customer,
			['namespace' => 'contractDocument']);
	}
}