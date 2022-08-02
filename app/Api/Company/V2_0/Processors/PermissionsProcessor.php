<?php
namespace RealEstate\Api\Company\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class PermissionsProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'data' => 'int[]'
        ];
    }

    /**
     * @return array
     */
    public function getAppraiserStaffIds()
    {
        return $this->get('data', []);
    }
}