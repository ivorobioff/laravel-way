<?php
namespace RealEstate\Core\Appraiser\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Rules\Regex;
use Restate\Libraries\Validation\Value;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Tin extends AbstractRule
{
    const SSN_ONLY = [
        'pattern' => '[0-9]{3}\-[0-9]{2}\-[0-9]{4}',
        'mask' => 'xxx-xx-xxxx'
    ];

    const TAX_ONLY = [
        'pattern' => '[0-9]{2}\-[0-9]{7}',
        'mask' => 'xx-xxxxxxx'
    ];

    const SSN_OR_TAX = [
        'pattern' => '('.self::SSN_ONLY['pattern'].')|('.self::TAX_ONLY['pattern'].')',
        'mask' => self::SSN_ONLY['mask'].' or '.self::TAX_ONLY['mask']
    ];

    /**
     * @var string
     */
    private $pattern;

    public function __construct($pattern = self::SSN_OR_TAX)
    {
        $this->pattern = $pattern['pattern'];

        $this->setIdentifier('format');
        $this->setMessage('The Tax Identification Number has incorrect format. The allowed format is: '.$pattern['mask']);
    }

    /**
     *
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        $error = (new Regex('/^'.$this->pattern.'$/'))->check($value);

        if ($error) {
            return $this->getError();
        }

        return null;
    }
}