<?php
namespace RealEstate\Mobile\Support;
use Sly\NotificationPusher\Adapter\AdapterInterface;
use Sly\NotificationPusher\Model\Device;
use RealEstate\Core\User\Interfaces\DevicePreferenceInterface;
use Log;
use RealEstate\Core\User\Services\DeviceService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AdapterFactory
{
    /**
     * @var DevicePreferenceInterface
     */
    private $preference;

    /**
     * @var DeviceService
     */
    private $deviceService;

    /**
     * @param DevicePreferenceInterface $preference
     * @param DeviceService $deviceService
     */
    public function __construct(DevicePreferenceInterface $preference, DeviceService $deviceService)
    {
        $this->preference = $preference;
        $this->deviceService = $deviceService;
    }

    /**
     * @para
     * @return AdapterInterface
     */
    public function ios()
    {
        $adapter = new ApnsAdapter(['certificate' => storage_path('apns_certificate.pem')]);

        $adapter->setErrorListener(function(Device $device, $error, $code){
            Log::warning($device->getToken().': '.$error);

            if ($code == ApnsAdapter::ERROR_INVALID_TOKEN){
                $this->deviceService->deleteByToken($device->getToken());
            }
        });

        return $adapter;
    }

    /**
     * @return AdapterInterface
     */
    public function android()
    {
        return  new FcmAdapter(['key' => $this->preference->getAndroidKey()]);
    }
}