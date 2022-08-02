<?php
namespace RealEstate\Letter\Handlers\Amc;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use RealEstate\Core\Amc\Emails\InvoiceEmail;
use RealEstate\Core\Document\Interfaces\DocumentPreferenceInterface;
use RealEstate\Letter\Support\HandlerInterface;
use RealEstate\Support\Shortcut;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class InvoiceEmailHandler implements HandlerInterface
{
    /**
     * @var DocumentPreferenceInterface
     */
    private $preference;

    /**
     * @param DocumentPreferenceInterface $preference
     */
    public function __construct(DocumentPreferenceInterface $preference)
    {
        $this->preference = $preference;
    }

    /**
     * @param Mailer $mailer
     * @param InvoiceEmail $source
     */
    public function handle(Mailer $mailer, $source)
    {
        $invoice = $source->getInvoice();

        $from = $invoice->getFrom()->format('m/d/Y');
        $to = $invoice->getTo()->format('m/d/Y');

        $data = [
            'actionUrl' => Shortcut::extractUrlFromDocument($source->getInvoice()->getDocument(), $this->preference),
            'from' => $from,
            'to' => $to
        ];

        $mailer->queue('emails.amc.invoice', $data, function(Message $message) use ($source, $from, $to) {
            $message->from($source->getSender()->getEmail(), $source->getSender()->getName());

            foreach ($source->getRecipients() as $recipient){
                $message->to($recipient->getEmail(), $recipient->getName());
            }

            $message->subject('Invoice: '.$from.' - '.$to);
        });
    }
}