<?php
namespace RealEstate\Api\Amc\V2_0\Transformers;
use RealEstate\Api\Assignee\V2_0\Support\CoverageReformatter;
use RealEstate\Api\Support\BaseTransformer;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicenseTransformer extends BaseTransformer
{
    /**
     * @param object $item
     * @return array
     */
    public function transform($item)
    {
        $data = $this->extract($item, [
            'map' => [
                'coverages' => 'coverage'
            ]
        ]);

        $data['coverage'] = CoverageReformatter::reformat($data['coverage']);

        return $data;
    }
}