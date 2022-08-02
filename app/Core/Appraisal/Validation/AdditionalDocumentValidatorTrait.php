<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\SourceHandlerInterface;
use RealEstate\Core\Appraisal\Validation\Rules\AdditionalDocumentTypeExists;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Document\Validation\DocumentInflator;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait AdditionalDocumentValidatorTrait
{
	/**
	 * @param Binder $binder
	 * @param ContainerInterface $container
	 * @param Customer $customer
	 * @param array $options
	 */
	protected function defineAdditionalDocument(
		Binder $binder,
		ContainerInterface $container,
		Customer $customer,
		array $options = []
	)
	{
		if ($namespace = $path = array_take($options, 'namespace', '')){
			$namespace .= '.';
		}

		/**
		 * @var CustomerService $customerService
		 */
		$customerService = $container->get(CustomerService::class);

		$binder->bind($namespace.'type', function(Property $property) use ($customerService, $customer){
			$property
				->addRule(new AdditionalDocumentTypeExists($customerService, $customer));
		});

		$binder->bind($namespace.'label', function(Property $property){
			$property
				->addRule(new Blank())
				->addRule(new Length(1, 255));
		});

		$binder->bind($namespace.'label', function(Property $property){
			$property
				->addRule(new Obligate());
		})->when(function(SourceHandlerInterface $source) use ($namespace, $path){
			return $source->getValue($namespace.'type') === null && (!$path || $source->hasProperty($path));
		});

		$bundle = $binder
			->bind($namespace.'document', (new DocumentInflator($container))->setRequired(true));

		if ($path){
			$bundle->when(function(SourceHandlerInterface $source) use ($path){
				return $source->hasProperty($path);
			});
		}
	}
}