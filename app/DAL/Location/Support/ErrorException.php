<?php
namespace RealEstate\DAL\Location\Support;

use Exception;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ErrorException extends Exception
{
    /**
     * @var Error
     */
    private $error;

    /**
     * @param Error $error
     * @param string $message
     */
    public function __construct(Error $error, $message)
    {
        parent::__construct($message);

        $this->error = $error;
    }

    /**
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }
}