<?php
namespace RealEstate\Api\Company\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReassignOrderProcessor extends BaseProcessor
{
    protected function configuration()
    {
        return [
            'appraiser' => 'int'
        ];
    }

    /**
     * @return int
     */
    public function getAppraiser()
    {
        return $this->get('appraiser');
    }
}