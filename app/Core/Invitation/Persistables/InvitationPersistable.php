<?php
namespace RealEstate\Core\Invitation\Persistables;

use RealEstate\Core\Invitation\Properties\RequirementsPropertyTrait;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InvitationPersistable
{
	use RequirementsPropertyTrait;

	/**
	 * @var int
	 */
	private $ascAppraiser;

	/**
	 * @var int
	 */
	private $appraiser;

	/**
	 * @return int
	 */
	public function getAscAppraiser()
	{
		return $this->ascAppraiser;
	}

	/**
	 * @param int $appraiser
	 */
	public function setAscAppraiser($appraiser)
	{
		$this->ascAppraiser = $appraiser;
	}

	/**
	 * @param int $appraiser
	 */
	public function setAppraiser($appraiser)
	{
		$this->appraiser = $appraiser;
	}

	/**
	 * @return int
	 */
	public function getAppraiser()
	{
		return $this->appraiser;
	}
}