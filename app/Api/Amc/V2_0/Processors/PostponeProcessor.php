<?php
namespace RealEstate\Api\Amc\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;

class PostponeProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'explanation' => 'string',
        ];
    }

    /**
     * @return string
     */
    public function getExplanation()
    {
        return $this->get('explanation');
    }
}
