<?php
namespace RealEstate\Live\Handlers;
use RealEstate\Api\Appraisal\V2_0\Transformers\AdditionalDocumentTransformer;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Core\Appraisal\Notifications\CreateAdditionalDocumentNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CreateOrderAdditionalDocumentHandler extends AbstractOrderHandler
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'create-additional-document';
    }

    /**
     * @param CreateAdditionalDocumentNotification $notification
     * @return array
     */
    protected function getData($notification)
    {
        return [
            'order' => $this->transformer(OrderTransformer::class)->transform($notification->getOrder()),
            'additionalDocument' => $this->transformer(AdditionalDocumentTransformer::class)
                ->transform($notification->getAdditionalDocument())
        ];
    }
}