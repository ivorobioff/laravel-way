<?php
namespace RealEstate\DAL\Support;

use Doctrine\ORM\Decorator\EntityManagerDecorator as AbstractEntityManagerDecorator;
use RealEstate\Core\Location\Entities\State;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class EntityManagerDecorator extends AbstractEntityManagerDecorator
{
    /**
     * @param string $entityName
     * @param mixed $id
     * @return object
     */
    public function getReference($entityName, $id)
    {
        if ($entityName === State::class || is_subclass_of($entityName, State::class)){
            $id = strtoupper($id);
        }

        return parent::getReference($entityName, $id);
    }
}