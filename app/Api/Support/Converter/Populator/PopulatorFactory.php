<?php
namespace RealEstate\Api\Support\Converter\Populator;

use Restate\Libraries\Converter\Populator\Populator;
use Restate\Libraries\Processor\DefaultPopulatorFactory;
use Restate\Libraries\Modifier\Manager;

/**
 *
 * @author Sergei Melnikov <me@rnr.name>
 */
class PopulatorFactory extends DefaultPopulatorFactory
{
    /**
     * @param array $options
     * @param Manager $modifierManager
     * @return Populator
     */
    public function create(array $options = [], Manager $modifierManager = null)
    {
        $populator = parent::create($options, $modifierManager);

        $populator->addGlobalResolver(new DocumentPersistableResolver());
        $populator->addGlobalResolver(new DocumentIdentifierResolver());
        $populator->addGlobalResolver(new DocumentIdentifiersResolver());

        return $populator;
    }
}