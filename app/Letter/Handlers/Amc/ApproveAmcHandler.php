<?php
namespace RealEstate\Letter\Handlers\Amc;
use Illuminate\Mail\Mailer;
use Illuminate\Mail\Message;
use RealEstate\Core\Amc\Notifications\ApproveAmcNotification;
use RealEstate\Core\Support\Letter\LetterPreferenceInterface;
use RealEstate\Letter\Support\HandlerInterface;
use Illuminate\Config\Repository as Config;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ApproveAmcHandler implements HandlerInterface
{
    /**
     * @var LetterPreferenceInterface
     */
    private $preference;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param LetterPreferenceInterface $preference
     * @param Config $config
     */
    public function __construct(LetterPreferenceInterface $preference, Config $config)
    {
        $this->preference = $preference;
        $this->config = $config;
    }

    /**
     * @param Mailer $mailer
     * @param ApproveAmcNotification $source
     */
    public function handle(Mailer $mailer, $source)
    {
        $noReply = $this->preference->getNoReply();
        $signature = $this->preference->getSignature();
        $amc = $source->getAmc();

        $mailer->queue('emails.amc.approve_amc', [
            'actionUrl' => $this->config->get('app.front_end_url').'/login'
        ], function(Message $message) use ($noReply, $signature, $amc){
            $message->from($noReply, $signature);
            $message->subject('Your AMC account has been approved');
            $message->to($amc->getEmail(), $amc->getCompanyName());
        });
    }
}