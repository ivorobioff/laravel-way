<?php
namespace RealEstate\Api\Session\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\IntegerCast;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\User\Services\UserService;
use RealEstate\Core\User\Validation\Rules\UserExists;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DeleteAllProcessor extends AbstractProcessor
{
    /**
     * @param Binder $binder
     * @return void
     */
    protected function rules(Binder $binder)
    {
        $binder->bind('user', function (Property $property) {
            $property->addRule(new Obligate())
                ->addRule(new IntegerCast(true))
                ->addRule(new UserExists($this->container->make(UserService::class)));
        });
    }
} 