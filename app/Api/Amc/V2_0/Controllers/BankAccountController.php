<?php
namespace RealEstate\Api\Amc\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Amc\V2_0\Processors\BankAccountProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Payment\Objects\BankAccount;
use RealEstate\Core\Payment\Services\PaymentService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class BankAccountController extends BaseController
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
     * @param BankAccountProcessor $processor
     * @return Response
     */
    public function change($amcId, BankAccountProcessor $processor)
    {
        return $this->resource->make(
            $this->paymentService->changeBankAccount($amcId, $processor->createRequisites()),
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
            $this->paymentService->getBankAccount($amcId) ?? new BankAccount(),
            $this->transformer()
        );
    }

    /**
     * @param AmcService $amcService
     * @param int $amcId
     * @return bool
     */
    public static function verifyAction(AmcService $amcService, $amcId)
    {
        return $amcService->exists($amcId);
    }
}