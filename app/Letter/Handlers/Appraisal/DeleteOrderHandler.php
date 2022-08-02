<?php
namespace RealEstate\Letter\Handlers\Appraisal;

use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use Illuminate\Mail\Mailer;


/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeleteOrderHandler extends AbstractOrderHandler
{
	/**
	 * @param AbstractNotification $notification
	 * @return string
	 */
	protected function getSubject(AbstractNotification $notification)
	{
		return 'Deleted - Order on '.$notification->getOrder()->getProperty()->getDisplayAddress();
	}

	/**
	 * @return string
	 */
	protected function getTemplate()
	{
		return 'emails.appraisal.delete_order';
	}

    /**
     * @param Mailer $mailer
     * @param AbstractNotification $source
     */
	public function handle(Mailer $mailer, $source)
    {
        // we don't want to send an email when a bit request is deleted

        if ($source->getOrder()->getProcessStatus()->is(ProcessStatus::REQUEST_FOR_BID)){
            return ;
        }

        parent::handle($mailer, $source);
    }
}