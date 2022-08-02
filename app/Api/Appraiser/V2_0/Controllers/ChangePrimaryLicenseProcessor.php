<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\IntegerCast;
use Restate\Libraries\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ChangePrimaryLicenseProcessor extends AbstractProcessor
{
	protected function rules(Binder $binder)
	{
		$binder->bind('license', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new IntegerCast());
		});
	}

	public function getLicense()
	{
		return (int) $this->get('license');
	}
}