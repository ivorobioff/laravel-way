<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use RealEstate\Api\Appraisal\V2_0\Support\AdditionalDocumentsConfigurationTrait;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraisal\Objects\Comparable;
use RealEstate\Core\Appraisal\Persistables\ReconsiderationPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReconsiderationsProcessor extends BaseProcessor
{
    use AdditionalDocumentsConfigurationTrait;

	protected function configuration()
	{
		return array_merge([
            'comment' => 'string',
            'comparables' => [
                'address' => 'string',
                'salesPrice' => 'float',
                'closedDate' => 'datetime',
                'livingArea' => 'string',
                'siteSize' => 'string',
                'actualAge' => 'string',
                'distanceToSubject' => 'string',
                'sourceData' => 'string',
                'comment' => 'string'
            ]
        ], $this->getAdditionalDocumentsConfiguration(['namespace' => 'document']));
	}

	/**
	 * @return ReconsiderationPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new ReconsiderationPersistable(), [
			'hint' => [
				'comparables' => 'collection:'.Comparable::class
			]
		]);
	}
}