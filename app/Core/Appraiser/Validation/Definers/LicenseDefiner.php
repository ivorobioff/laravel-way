<?php
namespace RealEstate\Core\Appraiser\Validation\Definers;

use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Callback;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\NotClearable;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\SourceHandlerInterface;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Appraiser\Validation\Rules\LicenseNumberTaken;
use RealEstate\Core\Appraiser\Validation\Rules\StateUnique;
use RealEstate\Core\Assignee\Validation\Inflators\CoverageInflator;
use RealEstate\Core\Assignee\Validation\Rules\WalkWithState;
use RealEstate\Core\Asc\Services\AscService;
use RealEstate\Core\Asc\Validation\Rules\LicenseNumberExists;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Document\Validation\DocumentInflator;
use RealEstate\Core\Location\Services\CountyService;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Rules\StateExists;
use DateTime;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class LicenseDefiner
{
	/**
	 * @var ContainerInterface
	 */
	private $container;

	/**
	 * @var StateService
	 */
	private $stateService;

	/**
	 * @var AscService
	 */
	private $ascService;

	/**
	 * @var AppraiserService
	 */
	private $appraiserService;

	/**
	 * @var CountyService
	 */
	private $countyService;

	/**
	 * @var string
	 */
	private $namespace = '';

	/**
	 * @var bool
	 */
	private $bypassValidateExistence = false;

	/**
	 * @var Appraiser
	 */
	private $currentAppraiser;

	/**
	 * @var SourceHandlerInterface
	 */
	private $origin;

	/**
	 * @var Document
	 */
	private $trustedDocument;

	/**
	 * @var bool
	 */
	private $validateExpiresAt = true;

	/**
	 * @var EnvironmentInterface
	 */
	private $environment;

	/**
	 * @param ContainerInterface $container
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->stateService = $container->get(StateService::class);
		$this->ascService = $container->get(AscService::class);
		$this->appraiserService = $container->get(AppraiserService::class);
		$this->countyService = $container->get(CountyService::class);
		$this->environment = $container->get(EnvironmentInterface::class);
	}

	/**
	 * @param Binder $binder
	 */
	public function defineOnCreate(Binder $binder)
	{
		$binder->bind($this->namespace.'number', function (Property $property) {
			$property
				->addRule(new Obligate())
				->addRule(new Blank());
		});

		$binder->bind($this->namespace.'state', function (Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Length(2, 2))
				->addRule(new StateExists($this->stateService));

			if ($this->currentAppraiser){
				$property->addRule(new StateUnique($this->appraiserService, $this->currentAppraiser));
			}
		});

		$binder->bind($this->namespace.'number', [$this->namespace.'number', $this->namespace.'state'],
			function (Property $property){

				if ($this->bypassValidateExistence === false){
					$property->addRule(new LicenseNumberExists($this->ascService));
				}

				$property->addRule(new LicenseNumberTaken($this->appraiserService));
			});


		$this->define($binder);
	}

	/**
	 * @param Binder $binder
	 */
	public function defineOnUpdate(Binder $binder)
	{
		$binder->bind($this->namespace.'number', function (Property $property) {
			$property->addRule($this->readOnly(function(){
				return !$this->origin->hasProperty($this->namespace.'number');
			}));
		});

		$binder->bind($this->namespace.'state', function (Property $property){
			$property->addRule($this->readOnly(function(){
				return !$this->origin->hasProperty($this->namespace.'state');
			}));
		});

		$binder->bind($this->namespace.'isFhaApproved', function(Property $property){
			$property
				->addRule(new NotClearable());
		});

		$binder->bind($this->namespace.'isCommercial', function(Property $property){
			$property
				->addRule(new NotClearable());
		});

		$this->define($binder);
	}

	/**
	 * @param Binder $binder
	 */
	private function define(Binder $binder)
	{
		$binder->bind($this->namespace.'expiresAt', function (Property $property){

			if (!$this->environment->isRelaxed()){
				$property->addRule(new Obligate());
			}

			if ($this->validateExpiresAt){
				$property->addRule(new Greater(new DateTime()));
			}
		});

		$binder->bind($this->namespace.'certifications', function (Property $property) {
			$property
				->addRule(new Obligate())
				->addRule(new Blank());
		});

		$inflator = new DocumentInflator($this->container);

		if ($this->trustedDocument){
			$inflator->setTrustedDocuments([$this->trustedDocument]);
		}

		$binder->bind($this->namespace.'document', $inflator);

		$binder->bind($this->namespace.'coverages', [$this->namespace.'coverages', $this->namespace.'state'],
			function(Property $property){
				$property
					->addRule(new WalkWithState(
						new CoverageInflator($this->stateService, $this->countyService)
					));

			});
	}

	/**
	 * @param callable $callback
	 * @return AbstractRule
	 */
	private function readOnly(callable $callback)
	{
		return (new Callback($callback))
			->setIdentifier('read-only')
			->setMessage('The property cannot be updated.');
	}

	/**
	 * @param bool $flag
	 * @return $this
	 */
	public function setBypassValidateExistence($flag)
	{
		$this->bypassValidateExistence = $flag;

		return $this;
	}

	/**
	 * @param string $namespace
	 * @return $this
	 */
	public function setNamespace($namespace)
	{
		$this->namespace = $namespace.'.';
		return $this;
	}

	/**
	 * @param Appraiser $appraiser
	 * @return $this
	 */
	public function setCurrentAppraiser(Appraiser $appraiser)
	{
		$this->currentAppraiser = $appraiser;
		return $this;
	}

	/**
	 * @param Document $document
	 * @return $this
	 */
	public function setTrustedDocument(Document $document = null)
	{
		$this->trustedDocument = $document;
		return $this;
	}

	/**
	 * @param SourceHandlerInterface $source
	 * @return $this
	 */
	public function setOrigin(SourceHandlerInterface $source)
	{
		$this->origin = $source;
		return $this;
	}

	/**
	 * @param bool $flag
	 * @return $this
	 */
	public function setValidateExpiresAt($flag)
	{
		$this->validateExpiresAt = $flag;
		return $this;
	}
}