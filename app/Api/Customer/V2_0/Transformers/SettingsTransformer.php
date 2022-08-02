<?php
namespace RealEstate\Api\Customer\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Customer\Entities\Settings;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SettingsTransformer extends BaseTransformer
{
	/**
	 * @param Settings $settings
	 * @return array
	 */
	public function transform($settings)
	{
		return $this->extract($settings);
	}
}