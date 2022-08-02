<?php
namespace RealEstate\Core\Appraisal\Persistables;

use RealEstate\Core\Document\Persistables\Identifier;
use RealEstate\Core\Document\Persistables\Identifiers;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentPersistable
{
	/**
	 * @var Identifier
	 */
	private $primary;
	public function setPrimary(Identifier $identifier) { $this->primary = $identifier; }
	public function getPrimary() { return $this->primary; }

	/**
	 * @var Identifiers|Identifier[]
	 */
	private $primaries;
	public function setPrimaries(Identifiers $identifiers) { $this->primaries = $identifiers; }
	public function getPrimaries() { return $this->primaries; }


	/**
	 * @var Identifiers|Identifier[]
	 */
	private $extra;
	public function setExtra(Identifiers $identifiers) { $this->extra = $identifiers; }
	public function getExtra() { return $this->extra; }

	/**
	 * @var bool
	 */
	private $showToAppraiser;
	public function setShowToAppraiser($flag) { $this->showToAppraiser = $flag; }
	public function getShowToAppraiser() { return $this->showToAppraiser; }
}