<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\ErrorsThrowableCollection;
use Restate\Libraries\Validation\SourceHandlerInterface;
use RealEstate\Core\Support\Validation\AbstractConstraints;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Constraints extends AbstractConstraints
{
	const IS_PAID_EQUALS_TRUE = 'isPaidEqualsTrue';
	const PAID_AT_NOT_SPECIFIED = 'paidAtNotSpecified';

	/**
	 * @param SourceHandlerInterface $source
	 * @param ErrorsThrowableCollection $errors
	 * @return bool
	 */
	public function isPaidEqualsTrue(
		SourceHandlerInterface $source,
		ErrorsThrowableCollection $errors
	)
	{
		return !isset($errors['isPaid']) && $source->getValue('isPaid') === true;
	}


	/**
	 * @param SourceHandlerInterface $source
	 * @param ErrorsThrowableCollection $errors
	 * @return bool
	 */
	public function paidAtNotSpecified(
		SourceHandlerInterface $source,
		ErrorsThrowableCollection $errors
	)
	{
		return !isset($errors['paidAt']) && !$source->hasProperty('paidAt');
	}
}