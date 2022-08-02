<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Appraisal\V2_0\Support\AdditionalDocumentsConfigurationTrait;
use RealEstate\Api\Appraisal\V2_0\Support\ConditionsConfigurationTrait;
use RealEstate\Api\Location\V2_0\Processors\LocationConfigurationProviderTrait;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraisal\Enums\AssetType;
use RealEstate\Core\Appraisal\Enums\ConcessionUnit;
use RealEstate\Core\Appraisal\Enums\Property\ApproachToBeIncluded;
use RealEstate\Core\Appraisal\Enums\Property\BestPersonToContact;
use RealEstate\Core\Appraisal\Enums\Property\ContactType;
use RealEstate\Core\Appraisal\Enums\Property\Occupancy;
use RealEstate\Core\Appraisal\Enums\Property\OwnerInterest;
use RealEstate\Core\Appraisal\Enums\Property\ValueQualifier;
use RealEstate\Core\Appraisal\Enums\Property\ValueType;
use RealEstate\Core\Appraisal\Persistables\ContactPersistable;
use RealEstate\Core\Appraisal\Persistables\CreateOrderPersistable;
use RealEstate\Core\Appraisal\Persistables\ExternalDocumentPersistable;
use RealEstate\Core\Appraisal\Persistables\AbstractOrderPersistable;
use RealEstate\Core\Appraisal\Persistables\UpdateOrderPersistable;
use RealEstate\Core\Document\Enums\Format;
use RealEstate\Core\Invitation\Enums\Requirement;
use RealEstate\Core\Appraisal\Enums\ValueQualifier as OrderValueQualifier;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrdersProcessor extends BaseProcessor
{
	use LocationConfigurationProviderTrait;
	use ConditionsConfigurationTrait;
	use AdditionalDocumentsConfigurationTrait;

	protected function configuration()
	{
		$propertyLocation = $this->getLocationConfiguration([
			'prefix' => 'property.'
		]);

		$document = [
			'url' => 'string',
			'name' => 'string',
			'format' => new Enum(Format::class),
			'size' => 'int'
		];

		$acceptedConditions = $this->getConditionsConfiguration(['namespace' => 'acceptedConditions']);

		$acceptedConditions['acceptedConditions.additionalComments'] = 'string';

		if ($this->isPatch()){
			$contractDocument['contractDocument'] = 'int';
		} else {
			$contractDocument = $this->getAdditionalDocumentsConfiguration(['namespace' => 'contractDocument']);
		}

		return array_merge([
			'isBidRequest' => 'bool',
			'fileNumber' => 'string',
            'intendedUse' => 'string',
			'referenceNumber' => 'string',
			'rulesets' => 'int[]',
			'client' => 'int',
			'clientDisplayedOnReport' => 'int',
			'amcLicenseNumber' => 'string',
			'amcLicenseExpiresAt' => 'datetime',
			'jobType' => 'int',
			'additionalJobTypes' => 'int[]',
			'fee' => 'float',
			'techFee' => 'float',
			'purchasePrice' => 'float',
			'isRush' => 'bool',
			'isPaid' => 'bool',
			'fhaNumber' => 'string',
			'loanNumber' => 'string',
			'loanType' => 'string',
			'contractDate' => 'datetime',
			'concession' => 'float',
			'concessionUnit' => new Enum(ConcessionUnit::class),
			'salesPrice' => 'float',
			'approachesToBeIncluded' => new Enum(ApproachToBeIncluded::class),
			'dueDate' => 'datetime',
			'orderedAt' => 'datetime',
			'assignedAt' => 'datetime',
			'paidAt' => 'datetime',
            'inspectionScheduledAt' => 'datetime',
            'inspectionCompletedAt' => 'datetime',
            'estimatedCompletionDate' => 'datetime',
            'fdic' => 'array',
            'fdic.fin' => 'string',
            'fdic.taskOrder' => 'string',
            'fdic.line' => 'int',
            'fdic.contractor' => 'string',
            'fdic.assetNumber' => 'string',
            'fdic.assetType' => new Enum(AssetType::class),
			'property.type' => 'string',
			'property.viewType' => 'string',
            'property.characteristics' => 'string[]',
			'property.approxBuildingSize' => 'float',
			'property.approxLandSize' => 'float',
			'property.buildingAge' => 'int',
			'property.numberOfStories' => 'int',
			'property.numberOfUnits' => 'int',
			'property.grossRentalIncome' => 'float',
			'property.incomeSalesCost' => 'float',
			'property.valueTypes' => [new Enum(ValueType::class)],
			'property.valueQualifiers' => [new Enum(ValueQualifier::class)],
			'property.ownerInterest' => new Enum(OwnerInterest::class),
			'property.ownerInterests' => [new Enum(OwnerInterest::class)],
			'property.county' => 'int',
			'property.occupancy' => new Enum(Occupancy::class),
			'property.bestPersonToContact' => new Enum(BestPersonToContact::class),
			'property.legal' => 'string',
			'property.additionalComments' => 'string',
			'property.contacts' => [
				'type' => new Enum(ContactType::class),
				'name' => 'string',
				'firstName' => 'string',
				'lastName' => 'string',
				'middleName' => 'string',
				'homePhone' => 'string',
				'cellPhone' => 'string',
				'workPhone' => 'string',
				'email' => 'string',
                'intentProceedDate' => 'datetime'
			],
			'instruction' => 'string',
			'instructionDocuments' => $document,
			'additionalDocuments' => $document,
			'invitation' => [
				'requirements' =>  [new Enum(Requirement::class)]
			],
            'lienPosition' => 'string',
            'valueQualifiers' => [new Enum(OrderValueQualifier::class)]
		], $propertyLocation, $acceptedConditions, $contractDocument);
	}

	/**
	 * @return AbstractOrderPersistable|UpdateOrderPersistable|CreateOrderPersistable
	 */
	public function createPersistable()
	{
		$options = [
			'hint' => [
				'property.contacts' => 'collection:'.ContactPersistable::class,
				'instructionDocuments' => 'collection:'.ExternalDocumentPersistable::class,
				'additionalDocuments' => 'collection:'.ExternalDocumentPersistable::class
			]
		];

		if ($this->isPatch()){
			return $this->populate(new UpdateOrderPersistable(), $options);
		}

		return $this->populate(new CreateOrderPersistable(), $options);
	}
}