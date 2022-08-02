<?php
namespace RealEstate\Api\Support;

use Restate\Libraries\Converter\Extractor\Extractor;
use Restate\Libraries\Transformer\AbstractTransformer;
use RealEstate\Api\Support\Converter\Extractor\ExtraResolver;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class BaseTransformer extends AbstractTransformer
{
    /**
     * @param mixed $value
     * @param string|array $modifier
     * @return mixed
     */
    public function modify($value, $modifier)
    {
        return $this->getModifierManager()->modify($value, $modifier);
    }

	/**
	 * @param array $options
	 * @return Extractor
	 */
	protected function createExtractor(array $options = [])
	{
		$extractor = parent::createExtractor($options);

		$extraResolver = new ExtraResolver();

		$extraResolver->setModifier($this->getModifierManager());

		$extractor->addGlobalResolver($extraResolver);

		return $extractor;
	}

	
}