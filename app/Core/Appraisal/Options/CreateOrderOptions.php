<?php
namespace RealEstate\Core\Appraisal\Options;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateOrderOptions
{
    /**
     * @var int
     */
    private $fromStaff;


    /**
     * @param bool $flag
     * @return $this
     */
	public function setFromStaff($flag)
    {
        $this->fromStaff = $flag;
    }

    /**
     * @return int
     */
    public function isFromStaff()
    {
        return $this->fromStaff;
    }
}