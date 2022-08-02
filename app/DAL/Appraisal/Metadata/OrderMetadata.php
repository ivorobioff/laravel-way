<?php
namespace RealEstate\DAL\Appraisal\Metadata;

use Doctrine\ORM\Mapping\Builder\ClassMetadataBuilder;
use RealEstate\Core\Appraisal\Entities\AcceptedConditions;
use RealEstate\Core\Appraisal\Entities\AdditionalDocument;
use RealEstate\Core\Appraisal\Entities\AdditionalExternalDocument;
use RealEstate\Core\Appraisal\Entities\Bid;
use RealEstate\Core\Appraisal\Entities\Fdic;
use RealEstate\Core\Appraisal\Entities\InstructionExternalDocument;
use RealEstate\Core\Appraisal\Entities\Property;
use RealEstate\Core\Appraisal\Entities\SupportingDetails;
use RealEstate\Core\Company\Entities\Staff;
use RealEstate\Core\Customer\Entities\AdditionalStatus;
use RealEstate\Core\Customer\Entities\Client;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Entities\JobType;
use RealEstate\Core\Customer\Entities\Ruleset;
use RealEstate\Core\Invitation\Entities\Invitation;
use RealEstate\Core\User\Entities\User;
use RealEstate\DAL\Appraisal\Types\ApproachesToBeIncludedType;
use RealEstate\DAL\Appraisal\Types\ConcessionUnitType;
use RealEstate\DAL\Appraisal\Types\OrderValueQualifiers;
use RealEstate\DAL\Appraisal\Types\ProcessStatusType;
use RealEstate\DAL\Appraisal\Types\WorkflowType;
use RealEstate\DAL\Support\Metadata\AbstractMetadataProvider;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrderMetadata extends AbstractMetadataProvider
{
	/**
	 * @param ClassMetadataBuilder $builder
	 * @return void
	 */
	public function define(ClassMetadataBuilder $builder)
	{
		$builder->setTable('orders');

		$this->defineId($builder);

		$builder
			->createField('fileNumber', 'string')
			->length(static::FILE_NUMBER_LENGTH)
			->build();

        $builder
            ->createField('intendedUse', 'string')
            ->nullable(true)
            ->build();

		$builder
			->createField('referenceNumber', 'string')
			->nullable(true)
			->build();

		$builder
			->createManyToOne('client', Client::class)
			->build();

		$builder
			->createManyToOne('clientDisplayedOnReport', Client::class)
			->build();

		$builder
			->createField('amcLicenseNumber', 'string')
			->nullable(true)
			->length(100)
			->build();

		$builder
			->createField('amcLicenseExpiresAt', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('fee', 'float')
			->nullable(true)
			->build();

		$builder
			->createField('techFee', 'float')
			->nullable(true)
			->build();

		$builder
			->createField('purchasePrice', 'float')
			->nullable(true)
			->build();

		$builder
			->createField('fhaNumber', 'string')
			->nullable(true)
			->length(100)
			->build();

		$builder
			->createField('loanNumber', 'string')
			->nullable(true)
			->length(static::LOAN_NUMBER_LENGTH)
			->build();

		$builder
			->createField('loanType', 'string')
			->nullable(true)
			->build();

		$builder
			->createManyToOne('contractDocument', AdditionalDocument::class)
			->build();

		$builder
			->createField('contractDate', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('salesPrice', 'float')
			->nullable(true)
			->build();

		$builder
			->createField('concession', 'float')
			->nullable(true)
			->build();

		$builder
			->createField('concessionUnit', ConcessionUnitType::class)
			->nullable(true)
			->build();

		$builder
			->createField('processStatus', ProcessStatusType::class)
			->build();

		$builder
			->createField('approachesToBeIncluded', ApproachesToBeIncludedType::class)
			->build();

		$builder
			->createField('dueDate', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('orderedAt', 'datetime')
			->build();

		$builder
			->createField('instruction', 'text')
			->nullable(true)
			->build();

		$builder
			->createManyToOne('jobType', JobType::class)
			->build();

		$builder
			->createManyToMany('additionalJobTypes', JobType::class)
			->setJoinTable('order_additional_job_types')
			->build();

		$builder
			->createOneToMany('instructionDocuments', InstructionExternalDocument::class)
			->cascadeRemove()
			->mappedBy('order')
			->build();

		$builder
			->createOneToMany('additionalDocuments', AdditionalExternalDocument::class)
			->cascadeRemove()
			->mappedBy('order')
			->build();

		$builder
			->createField('inspectionScheduledAt', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('inspectionCompletedAt', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('estimatedCompletionDate', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('completedAt', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('assignedAt', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('acceptedAt', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('paidAt', 'datetime')
			->nullable(true)
			->build();

        $builder
            ->createOneToOne('fdic', Fdic::class)
            ->cascadeRemove()
            ->build();

		$builder
			->createOneToOne('property', Property::class)
			->cascadeRemove()
			->build();

		$builder
			->createManyToOne('assignee', User::class)
			->build();

        $builder
            ->createManyToOne('staff', Staff::class)
            ->build();

		$builder
			->createManyToOne('customer', Customer::class)
			->build();

		$builder
			->createOneToMany('bid', Bid::class)
			->mappedBy('order')
			->cascadeRemove()
			->build();

		$builder
			->createField('workflow', WorkflowType::class)
			->build();

		$builder
			->createField('comment', 'text')
			->nullable(true)
			->build();

        $builder
            ->createField('isRush', 'boolean')
            ->build();

		$builder
			->createField('isPaid', 'boolean')
			->build();

		$builder
			->createField('putOnHoldAt', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('revisionReceivedAt', 'datetime')
			->nullable(true)
			->build();

		$builder
			->createField('isTechFeePaid', 'boolean')
			->build();

		$builder
			->createManyToOne('additionalStatus', AdditionalStatus::class)
			->build();

		$builder
			->createField('additionalStatusComment', 'text')
			->nullable(true)
			->build();

		$builder
			->createManyToOne('invitation', Invitation::class)
			->build();

		$builder
			->createOneToOne('acceptedConditions', AcceptedConditions::class)
			->cascadeRemove()
			->build();

		$builder->createManyToMany('rulesets', Ruleset::class)
			->setJoinTable('orders_rulesets')
			->build();


        $builder->createField('lienPosition', 'string')
            ->nullable(true)
            ->build();

        $builder
            ->createField('valueQualifiers', OrderValueQualifiers::class)
            ->build();

		$builder->createField('createdAt', 'datetime')
			->nullable(true)
			->build();

		$builder->createField('updatedAt', 'datetime')
			->nullable(true)
			->build();

        $builder
            ->createOneToOne('supportingDetails', SupportingDetails::class)
            ->mappedBy('order')
            ->cascadeRemove()
            ->build();
	}
}