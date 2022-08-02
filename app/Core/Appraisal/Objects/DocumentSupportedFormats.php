<?php
namespace RealEstate\Core\Appraisal\Objects;

use RealEstate\Core\Customer\Enums\Formats;
use RealEstate\Core\Customer\Enums\ExtraFormats;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentSupportedFormats
{
	/**
	 * @var Formats
	 */
	private $primary;
	public function setPrimary(Formats $formats) { $this->primary = $formats; }
	public function getPrimary() { return $this->primary; }

	/**
	 * @var ExtraFormats
	 */
	private $extra;
	public function setExtra(ExtraFormats $formats = null) { $this->extra = $formats; }
	public function getExtra() { return $this->extra; }
}