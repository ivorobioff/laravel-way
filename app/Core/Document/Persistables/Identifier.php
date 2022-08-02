<?php
namespace RealEstate\Core\Document\Persistables;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Identifier
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $token;

	/**
	 * @param int $id
	 * @param string $token
	 */
	public function __construct($id = null, $token = null)
	{
		$this->id = $id;
		$this->token = $token;
	}

	/**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }
}