<?php
namespace RealEstate\Core\Appraiser\Notifications;
use RealEstate\Core\Appraiser\Entities\License;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractLicenseNotification extends AbstractAppraiserNotification
{
    /**
     * @var License
     */
    private $license;

    public function __construct(License $license)
    {
        parent::__construct($license->getAppraiser());
        $this->license = $license;
    }

    /**
     * @return License
     */
    public function getLicense()
    {
        return $this->license;
    }
}