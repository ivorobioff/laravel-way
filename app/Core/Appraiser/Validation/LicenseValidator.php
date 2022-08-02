<?php
namespace RealEstate\Core\Appraiser\Validation;

use Restate\Libraries\Converter\Transferer\Transferer;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Source\ObjectSourceHandler;
use Restate\Libraries\Validation\SourceHandlerInterface;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Entities\License;
use RealEstate\Core\Appraiser\Persistables\LicensePersistable;
use RealEstate\Core\Appraiser\Validation\Definers\LicenseDefiner;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Document\Persistables\Identifier;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicenseValidator extends AbstractThrowableValidator
{
	/**
	 * @var ContainerInterface $container
	 */
	private $container;

	/**
	 * @var bool
	 */
	private $isUpdate = false;

	/**
	 * @var Appraiser
	 */
	private $currentAppraiser;

	/**
	 * @var Document
	 */
	private $trustedDocument;

	/**
	 * @var SourceHandlerInterface
	 */
	private $origin;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
		$this->container = $container;
    }

    /**
     * @param Binder $binder
     */
    protected function define(Binder $binder)
    {
		if ($this->isUpdate){
			(new LicenseDefiner($this->container))
				->setTrustedDocument($this->trustedDocument)
				->setOrigin($this->origin)
				->defineOnUpdate($binder);
		} else{
			(new LicenseDefiner($this->container))
				->setCurrentAppraiser($this->currentAppraiser)
				->defineOnCreate($binder);
		}
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
	 * @param LicensePersistable $source
	 * @param License $license
	 */
	public function validateWithLicense(LicensePersistable $source, License $license)
	{
		$this->trustedDocument = $license->getDocument();
		$this->isUpdate = true;
		$this->origin = new ObjectSourceHandler($source, $this->getForcedProperties());

		$persistable = new LicensePersistable();

		(new Transferer([
			'ignore' => [
				'document',
				'coverages',
				'state',
				'appraiser',
			]
		]))->transfer($license, $persistable);

		if ($document = $license->getDocument()){
			$persistable->setDocument(new Identifier($document->getId()));
		}

		$persistable->adaptCoverages($license->getCoverages());

		if ($state = $license->getState()){
			$persistable->setState($state->getCode());
		}

		(new Transferer([
			'ignore' => [
				'coverages'
			],
			'nullable' => $this->getForcedProperties()
		]))->transfer($source, $persistable);

		if ($source->getCoverages() !== null){
			$persistable->setCoverages($source->getCoverages());
		}

		$this->validate($persistable);
	}
}