<?php
namespace RealEstate\Core\Appraisal\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Customer\Enums\ExtraFormat;
use RealEstate\Core\Customer\Enums\ExtraFormats;
use RealEstate\Core\Document\Persistables\Identifiers;
use RealEstate\Core\Document\Services\DocumentService as SourceService;
use RealEstate\Core\Document\Entities\Document as Source;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ExtraDocumentFormats extends AbstractRule
{
	/**
	 * @var SourceService
	 */
	private $sourceService;

	/**
	 * @var ExtraFormats
	 */
	private $supportedFormats;

	/**
	 * @var Source[]
	 */
	private $existingExtra;

	/**
	 * @param SourceService $sourceService
	 * @param Source[] $existingExtra
	 */
	public function __construct(SourceService $sourceService, $existingExtra)
	{
		$this->sourceService = $sourceService;
		$this->existingExtra = $existingExtra;

		$this->setIdentifier('format');
		$this->setMessage('The extra documents must be in the following formats: '.implode(', ', ExtraFormat::toArray()));
	}

	/**
	 * We don't verify format of already existing extra documents. It is possible that customers changed the list of
	 * supported formats after the documents were already uploaded.
	 *
	 * @param mixed|Value|Identifiers $value
	 * @return Error|null
	 */
	public function check($value)
	{
		$existingIds = [];

		foreach ($this->existingExtra as $extra){
			$existingIds[] = $extra->getId();
		}

		$sources = $this->sourceService->getAllSelected(array_diff($value->getIds(), $existingIds));

		foreach ($sources as $source){
			if (!$this->checkSource($source)){
				return $this->getError();
			}
		}

		return null;
	}

	/**
	 * @param Source $source
	 * @return bool
	 */
	private function checkSource(Source $source)
	{
		if ($this->supportedFormats){
			foreach ($this->supportedFormats as $supportedFormat){
				if ($source->getFormat()->isEqual($supportedFormat)){
					return true;
				}
			}
		} else {
			if (ExtraFormat::has($source->getFormat()->value())){
				return true;
			}
		}

		return false;
	}

	/**
	 * @param ExtraFormats $formats
	 * @return $this
	 */
	public function setSupportedFormats(ExtraFormats $formats)
	{
		$this->supportedFormats = $formats;
		$this->setMessage('The extra documents must be in the following formats: '.implode(', ', $formats->toArray()));
		return $this;
	}
}