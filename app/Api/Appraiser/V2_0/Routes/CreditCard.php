<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\CreditCardController;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreditCard implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar->put('appraisers/{appraiserId}/payment/credit-card', CreditCardController::class.'@replace');
		$registrar->get('appraisers/{appraiserId}/payment/credit-card', CreditCardController::class.'@show');
	}
}