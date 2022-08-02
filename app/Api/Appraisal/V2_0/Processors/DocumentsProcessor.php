<?php
namespace RealEstate\Api\Appraisal\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraisal\Persistables\DocumentPersistable;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Session\Entities\Session;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentsProcessor extends BaseProcessor
{
	/**
	 * @return array
	 */
	protected function configuration()
	{
		$config = [
			'primary' => 'document',
			'primaries' => 'document[]',
			'extra' => 'document[]'
		];

		/**
		 * @var Session $session
		 */
		$session = $this->container->make(Session::class);

		if ($session->getUser() instanceof Customer){
			$config['showToAppraiser'] = 'bool';
		}

		return $config;
	}

	/**
	 * @return DocumentPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new DocumentPersistable());
	}
}