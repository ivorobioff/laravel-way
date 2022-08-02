<?php
namespace RealEstate\Api\Support\Converter\Extractor;

use Restate\Libraries\Converter\Extractor\Resolvers\AbstractResolver;
use Restate\Libraries\Converter\Extractor\Root;
use Restate\Libraries\Enum\Enum;
use Restate\Libraries\Modifier\Manager;
use RealEstate\Core\Log\Extras\ExtraInterface;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ExtraResolver extends AbstractResolver
{
	/**
	 * @var Manager
	 */
	private $modifier;

	/**
	 * Checks whether the resolver can resolve a value
	 *
	 * @param string $scope
	 * @param Root $root
	 * @param mixed $value
	 * @return bool
	 */
	public function canResolve($scope, $value, Root $root = null)
	{
		return $value instanceof ExtraInterface;
	}

	/**
	 * Resolves a value
	 *
	 * @param string $scope
	 * @param Root $root
	 * @param ExtraInterface $value
	 * @return mixed
	 */
	public function resolve($scope, $value, Root $root = null)
	{
		return array_map_recursive(function($value){
			if ($value instanceof  DateTime){
				return $this->modifier->modify($value, 'datetime');
			}

			if ($value instanceof Enum){
				return (string) $value;
			}

			return $value;
		}, $value->getData());
	}

	/**
	 * @param Manager $manager
	 */
	public function setModifier(Manager $manager)
	{
		$this->modifier = $manager;
	}
}