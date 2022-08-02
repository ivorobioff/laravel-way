<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Amc\Persistables\FeeByStatePersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeesByStateProcessor extends BaseProcessor
{
    public static function metadata()
    {
        return [
            'state' => 'string',
            'amount' => 'float',
            'applyStateAmountToAllCounties' => 'bool',
            'applyStateAmountToAllZips' => 'bool'
        ];
    }

    protected function configuration()
    {
        return static::metadata();
    }

    /**
     * @return FeeByStatePersistable
     */
    public function createPersistable()
    {
        return $this->populate(new FeeByStatePersistable());
    }

    /**
     * @return bool
     */
    public function getApplyStateAmountToAllCounties()
    {
        return $this->get('applyStateAmountToAllCounties', false);
    }

    /**
     * @return bool
     */
    public function getApplyStateAmountToAllZips()
    {
        return $this->get('applyStateAmountToAllZips', false);
    }
}