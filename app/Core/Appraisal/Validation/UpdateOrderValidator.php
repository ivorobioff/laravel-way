<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Converter\Transferer\Transferer;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Persistables\ContactPersistable;
use RealEstate\Core\Appraisal\Persistables\ExternalDocumentPersistable;
use RealEstate\Core\Appraisal\Persistables\UpdateOrderPersistable;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Appraisal\Validation\Rules\AdditionalDocumentBelongs;
use RealEstate\Core\Customer\Entities\JobType;
use RealEstate\Core\Customer\Entities\Ruleset;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateOrderValidator extends AbstractOrderValidator
{
	public function define(Binder $binder)
	{
		parent::define($binder);

		$binder->bind('contractDocument', function(Property $property){
			/**
			 * @var OrderService $orderService
			 */
			$orderService = $this->container->get(OrderService::class);

			$property->addRule(new AdditionalDocumentBelongs($orderService, $this->existingOrder));
		});
	}

	/**
	 * @param UpdateOrderPersistable $source
	 * @param Order $order
	 */
	public function validateWithOrder(UpdateOrderPersistable $source, Order $order)
	{
		$this->existingOrder = $order;
		$this->isPaidClearable = false;

		$persistable = new UpdateOrderPersistable();

		(new Transferer([
			'ignore' => [
				'jobType',
				'client',
				'clientDisplayedOnReport',
				'additionalJobTypes',
				'contractDocument',
				'property.state',
				'property.county',
                'property.ownerInterest',
				'rulesets',
				'bid',
				'customer',
				'assignee',
                'staff',
                'company',
				'hasInstructionDocuments',
				'hasAdditionalDocuments',
				'property.hasContacts',
				'contractDocument',
				'additionalStatus',
				'invitation',
				'property.contacts.property',
                'supportingDetails'
			],
			'hint' => [
				'instructionDocuments' => 'collection:'.ExternalDocumentPersistable::class,
				'additionalDocuments' => 'collection:'.ExternalDocumentPersistable::class,
				'property.contacts' => 'collection:'.ContactPersistable::class
			]
		]))->transfer($order, $persistable);

		if ($client = $order->getClient()){
			$persistable->setClient($client->getId());
		}

		if ($clientDisplayedOnReport = $order->getClientDisplayedOnReport()){
			$persistable->setClientDisplayedOnReport($clientDisplayedOnReport->getId());
		}

		if ($jobType = $order->getJobType()){
			$persistable->setJobType($jobType->getId());
		}

		$persistable->setAdditionalJobTypes(array_map(
			function(JobType $jobType){ return $jobType->getId(); },
			iterator_to_array($order->getAdditionalJobTypes())
		));

		$persistable->setRulesets(array_map(function(Ruleset $ruleset){
			return $ruleset->getId();
		}, iterator_to_array($order->getRulesets())));


		if ($contractDocument = $order->getContractDocument()){
			$persistable->setContractDocument($contractDocument->getId());
		}

		if ($propertyState = $order->getProperty()->getState()){
			$persistable->getProperty()->setState($propertyState->getCode());
		}

		if ($propertyCounty = $order->getProperty()->getCounty()){
			$persistable->getProperty()->setCounty($propertyCounty->getId());
		}

		if ($contractDocument = $order->getContractDocument()){
			$persistable->setContractDocument($contractDocument->getId());
		}

		(new Transferer([
			'hint' => [
				'instructionDocuments' => 'collection:'.ExternalDocumentPersistable::class,
				'additionalDocuments' => 'collection:'.ExternalDocumentPersistable::class,
				'property.contacts' => 'collection:'.ContactPersistable::class
			],
			'nullable' => $this->getForcedProperties()
		]))->transfer($source, $persistable);


		$this->validate($persistable);
	}
}