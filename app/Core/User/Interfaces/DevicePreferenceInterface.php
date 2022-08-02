<?php
namespace RealEstate\Core\User\Interfaces;
use RealEstate\Core\User\Enums\Platform;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface DevicePreferenceInterface
{
    /**
     * @return string
     */
    public function getAndroidKey();

    /**
     * @param string $token
     * @param Platform $platform
     * @return bool
     */
    public function supports($token, Platform $platform);
}