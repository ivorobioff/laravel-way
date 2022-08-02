<?php
namespace RealEstate\Core\Appraiser\Validation\Definers;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\SourceHandlerInterface;
use RealEstate\Core\Appraiser\Validation\Rules\AvailabilityRange;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AvailabilityDefiner
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @param Binder $binder
     */
    public function define(Binder $binder)
    {
        if ($namespace = $path = $this->namespace){
            $namespace .= '.';
        }

        $bundle = $binder->bind($namespace.'isOnVacation', function(Property $property){
            $property->addRule(new Obligate());
        });

        if ($path){
            $bundle->when(function(SourceHandlerInterface $source) use ($path){
                return $source->hasProperty($path);
            });
        }

        foreach (['from', 'to'] as $edge){
            $binder->bind($namespace.$edge, function(Property $property){
                $property->addRule(new Obligate());
            })
                ->when(function(SourceHandlerInterface $s) use ($namespace, $path){
                    return $s->getValue($namespace.'isOnVacation') === true;
                });
        }

        $binder->bind($namespace.'from', [$namespace.'from', $namespace.'to'], function(Property $property){
            $property
                ->addRule(new AvailabilityRange());
        });

        $binder->bind($namespace.'message', function(Property $property){
            $property->addRule(new Length(0, 1000));
        });
    }

    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }
}