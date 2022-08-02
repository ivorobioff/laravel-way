<?php
namespace RealEstate\Tests\Integrations\Support\Runtime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Session
{
    /**
     * @var array
     */
    private $data;

    /**
     * Session constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $path
     * @return mixed|null
     */
    public function get($path = null)
    {
        if ($path){
            return array_get($this->data, $path);
        }

        return $this->data;
    }
}