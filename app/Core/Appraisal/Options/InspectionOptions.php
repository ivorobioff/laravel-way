<?php
namespace RealEstate\Core\Appraisal\Options;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InspectionOptions
{
    /**
     * @var bool
     */
    private $bypassDatesValidation = false;
    public function setBypassDatesValidation($flag) { $this->bypassDatesValidation = $flag; }
    public function getBypassDatesValidation() { return $this->bypassDatesValidation; }
}