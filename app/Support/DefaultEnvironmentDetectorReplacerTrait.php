<?php
namespace RealEstate\Support;

use Illuminate\Foundation\Bootstrap\DetectEnvironment;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait DefaultEnvironmentDetectorReplacerTrait
{

    protected function replaceDefaultDetectEnvironmentBootstrapper(array $bootstrappers)
    {
        $key = array_search(DetectEnvironment::class, $bootstrappers);
        unset($bootstrappers[$key]);
        array_unshift($bootstrappers, DetectEnvironmentBootstrapper::class);

        return $bootstrappers;
    }
}