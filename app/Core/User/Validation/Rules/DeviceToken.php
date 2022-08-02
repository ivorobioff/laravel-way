<?php
namespace RealEstate\Core\User\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\User\Enums\Platform;
use RealEstate\Core\User\Interfaces\DevicePreferenceInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DeviceToken extends AbstractRule
{
    /**
     * @var DevicePreferenceInterface
     */
    private $preference;

    /**
     * @param DevicePreferenceInterface $preference
     */
    public function __construct(DevicePreferenceInterface $preference)
    {
        $this->preference = $preference;

        $this->setMessage('The provided token is not supported by the specified platform.');
        $this->setIdentifier('invalid');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        /**
         * @var Platform $platform
         */
        list($token, $platform) = $value->extract();

        return $this->preference->supports($token, $platform) ? null : $this->getError();
    }
}