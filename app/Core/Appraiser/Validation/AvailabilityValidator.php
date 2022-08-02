<?php
namespace RealEstate\Core\Appraiser\Validation;

use Restate\Libraries\Converter\Transferer\Transferer;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use RealEstate\Core\Appraiser\Entities\Availability;
use RealEstate\Core\Appraiser\Persistables\AvailabilityPersistable;
use RealEstate\Core\Appraiser\Validation\Definers\AvailabilityDefiner;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AvailabilityValidator extends AbstractThrowableValidator
{
	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
        (new AvailabilityDefiner())->define($binder);
	}

	/**
	 * @param AvailabilityPersistable $source
	 * @param Availability $availability
	 */
	public function validateWithAvailability(AvailabilityPersistable $source, Availability $availability)
	{
		$persistable = new AvailabilityPersistable();

		(new Transferer())->transfer($availability, $persistable);
		(new Transferer(
			['nullable' => $this->getForcedProperties()]
		))->transfer($source, $persistable);

		$this->validate($persistable);
	}
}