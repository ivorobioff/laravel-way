<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\ReadOnly;
use Restate\Libraries\Validation\SourceHandlerInterface;
use RealEstate\Core\Appraisal\Objects\DocumentSupportedFormats;
use RealEstate\Core\Appraisal\Validation\Rules\ExtraDocumentFormats;
use RealEstate\Core\Appraisal\Validation\Rules\PrimaryDocumentFormat;
use RealEstate\Core\Appraisal\Validation\Rules\UniqueExtraDocumentFormats;
use RealEstate\Core\Appraisal\Validation\Rules\UniquePrimaryDocumentFormats;
use RealEstate\Core\Document\Validation\DocumentInflator;
use RealEstate\Core\Support\Service\ContainerInterface;
use RealEstate\Core\Document\Services\DocumentService as SourceService;
use RealEstate\Core\Document\Entities\Document as Source;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentValidator extends AbstractThrowableValidator
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * @var SourceService
	 */
	private $sourceService;

	/**
	 * @var DocumentSupportedFormats
	 */
	private $documentSupportedFormats;

	/**
	 * @var Source[]
	 */
	private $existingExtra = [];

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->sourceService = $container->get(SourceService::class);
	}

	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		foreach (['primary', 'primaries'] as $key){

			$binder->bind($key, function(Property $property){
				$property->addRule(new ReadOnly());
			})->when(function($s, $e, $isUpdate){ return $isUpdate; });

			if ($key === 'primary'){
				$binder->bind('primary', function(Property $property){
					$property->addRule(new Obligate());
				})->when(function(SourceHandlerInterface $source){
					return $source->hasProperty('primaries') === false;
				});
			}

			if ($key === 'primaries'){
				$binder->bind('primaries', function(Property $property){
					$property->addRule(new Blank());
				});
			}

			$binder->bind($key, (new DocumentInflator($this->container))->setRequired(false));

			if ($key === 'primaries'){
				$binder->bind('primaries', function(Property $property){
					$property->addRule(new UniquePrimaryDocumentFormats($this->sourceService));
				});
			}

			$binder->bind($key, function(Property $property){

				$formatRule = new PrimaryDocumentFormat($this->sourceService);

				if ($this->documentSupportedFormats){
					$formatRule->setSupportedFormats($this->documentSupportedFormats->getPrimary());
				}

				$property->addRule($formatRule);
			});
		}

		$binder->bind('extra', (new DocumentInflator($this->container))
			->setTrustedDocuments($this->existingExtra));

		$binder->bind('extra', function(Property $property){

			$formatRule = new ExtraDocumentFormats($this->sourceService, $this->existingExtra);

			if ($this->documentSupportedFormats){
				$formatRule->setSupportedFormats($this->documentSupportedFormats->getExtra());
			}

			$property
				->addRule($formatRule)
				->addRule(new UniqueExtraDocumentFormats($this->sourceService));
		});
	}

	/**
	 * @param Source[] $sources
	 * @return $this
	 */
	public function setExistingExtra($sources)
	{
		$this->existingExtra = $sources;
		return $this;
	}

	/**
	 * @param DocumentSupportedFormats $formats
	 * @return $this
	 */
	public function setSupportedFormats(DocumentSupportedFormats $formats)
	{
		$this->documentSupportedFormats = $formats;
		return $this;
	}
}