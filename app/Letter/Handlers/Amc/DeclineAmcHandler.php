<?php
namespace RealEstate\Letter\Handlers\Amc;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use RealEstate\Core\Amc\Notifications\DeclineAmcNotification;
use RealEstate\Core\Support\Letter\LetterPreferenceInterface;
use RealEstate\Letter\Support\HandlerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DeclineAmcHandler implements HandlerInterface
{
    /**
     * @var LetterPreferenceInterface
     */
    private $preference;

    /**
     * @param LetterPreferenceInterface $preference
     */
    public function __construct(LetterPreferenceInterface $preference)
    {
        $this->preference = $preference;
    }

    /**
     * @param Mailer $mailer
     * @param DeclineAmcNotification $source
     */
    public function handle(Mailer $mailer, $source)
    {
        $noReply = $this->preference->getNoReply();
        $signature = $this->preference->getSignature();
        $amc = $source->getAmc();

        $mailer->queue('emails.amc.decline_amc', [], function(Message $message) use ($noReply, $signature, $amc){
            $message->from($noReply, $signature);
            $message->subject('Your AMC account has been declined');
            $message->to($amc->getEmail(), $amc->getCompanyName());
        });
    }
}