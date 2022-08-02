<?php
namespace RealEstate\Push\Support;

use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Story
{
    /**
     * @var int
     */
    private $id;
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    /**
     * @var array
     */
    private $request;
    public function setRequest(array $request) { $this->request = $request; }
    public function getRequest() { return $this->request; }

    /**
     * @var array
     */
    private $response;
    public function setResponse(array $response) { $this->response = $response; }
    public function getResponse() { return $this->response; }

    /**
     * @var array
     */
    private $error;
    public function setError(array $error) { $this->error = $error; }
    public function getError() { return $this->error; }

    /**
     * @var DateTime
     */
    private $createdAt;
    public function setCreatedAt(DateTime $datetime) { $this->createdAt = $datetime; }
    public function getCreatedAt() { return $this->createdAt; }

    public function __construct()
    {
        $this->setCreatedAt(new DateTime());
    }
}