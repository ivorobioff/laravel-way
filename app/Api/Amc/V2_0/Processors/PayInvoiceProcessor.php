<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Enum;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Payment\Enums\Means;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PayInvoiceProcessor extends AbstractProcessor
{
    protected function rules(Binder $binder)
    {
        $binder->bind('means', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Enum(Means::class));

        });
    }

    /**
     * @return array
     */
    protected function allowable()
    {
        return [
            'means'
        ];
    }

    /**
     * @return Means
     */
    public function getMeans()
    {
        return new Means($this->get('means'));
    }
}