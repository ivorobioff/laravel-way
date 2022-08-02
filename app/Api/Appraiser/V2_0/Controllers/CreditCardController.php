<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Assignee\V2_0\Processors\CreditCardProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Payment\Objects\CreditCard;
use RealEstate\Core\Payment\Services\PaymentService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreditCardController extends BaseController
{
	/**
	 * @var PaymentService
	 */
	private $paymentService;

	/**
	 * @param PaymentService $paymentService
	 */
	public function initialize(PaymentService $paymentService)
	{
		$this->paymentService = $paymentService;
	}

    /**
     * @param int $amcId
     * @param CreditCardProcessor $processor
     * @return Response
     */
    public function replace($amcId, CreditCardProcessor $processor)
    {
        return $this->resource->make(
            $this->paymentService->switchCreditCard($amcId, $processor->createRequisites()),
            $this->transformer()
        );
    }

    /**
     * @param int $amcId
     * @return Response
     */
    public function show($amcId)
    {
        return $this->resource->make(
            $this->paymentService->getCreditCard($amcId) ?? new CreditCard(),
            $this->transformer()
        );
    }

	/**
	 * @param AppraiserService $appraiserService
	 * @param int $appraiserId
	 * @return bool
	 */
	public static function verifyAction(AppraiserService $appraiserService, $appraiserId)
	{
		return $appraiserService->exists($appraiserId);
	}
}