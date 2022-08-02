<?php
namespace RealEstate\Live\Handlers;
use RealEstate\Api\Appraisal\V2_0\Transformers\DocumentTransformer;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Core\Appraisal\Notifications\UpdateDocumentNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UpdateOrderDocumentHandler extends AbstractOrderHandler
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'update-document';
    }

    /**
     * @param UpdateDocumentNotification $notification
     * @return array
     */
    protected function getData($notification)
    {
        return [
            'order' => $this->transformer(OrderTransformer::class)->transform($notification->getOrder()),
            'document' => $this->transformer(DocumentTransformer::class)
                ->transform($notification->getDocument())
        ];
    }
}