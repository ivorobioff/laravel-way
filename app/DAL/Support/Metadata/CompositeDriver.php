<?php
namespace RealEstate\DAL\Support\Metadata;

use Doctrine\Common\Persistence\Mapping\Driver\MappingDriver;
use RuntimeException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CompositeDriver extends SimpleDriver
{
	/**
	 * @param MappingDriver[] $drivers
	 */
	public function __construct(array $drivers)
	{
		$source = [];

		foreach ($drivers as $driver){
			if ($driver instanceof MetadataClassesProvidableInterface){
				foreach ($driver->getMetadataClasses() as $entity => $metadata){
					if (isset($source[$entity])){
						throw new RuntimeException('The metadata for the "'.$entity.'" entity is already registered.');
					}

					$source[$entity] = $metadata;
				}
			}
		}

		parent::__construct($source);
	}
}