<?php
namespace RealEstate\Core\Shared\Interfaces;

use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface EnvironmentInterface
{
	/**
	 * It tells the system to bypass some limitations when importing appraisers from AS.
	 * IMPORTANT: It must be removed once all stuff from AS is moved to VP
	 *
	 * @return bool
	 */
	public function isRelaxed();

	/**
	 * @return DateTime
	 */
	public function getLogCreatedAt();

    /**
     * @return int
     */
    public function getAssigneeAsWhoActorActs();
}