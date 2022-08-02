<?php
namespace RealEstate\Core\Amc\Persistables;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SettingsPersistable
{
    /**
     * @var string
     */
    private $pushUrl;
    public function setPushUrl($url) { $this->pushUrl = $url; }
    public function getPushUrl() { return $this->pushUrl; }
}