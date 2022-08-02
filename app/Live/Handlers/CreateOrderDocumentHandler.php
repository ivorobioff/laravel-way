<?php
namespace RealEstate\Live\Handlers;
use RealEstate\Api\Appraisal\V2_0\Transformers\DocumentTransformer;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Api\Support\Converter\Extractor\Filters\AbstractAppraisalFilter;
use RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CreateOrderDocumentHandler extends AbstractOrderHandler
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'create-document';
    }

    /**
     * @param CreateDocumentNotification $notification
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