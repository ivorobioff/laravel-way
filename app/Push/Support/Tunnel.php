<?php
namespace RealEstate\Push\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Exception;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Tunnel
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $secret1;

    /**
     * @var string
     */
    private $secret2;

    /**
     * @var callable
     */
    private $listener;

    /**
     * @param string $url
     * @param string $secret1
     * @param string $secret2
     */
    public function __construct($url, $secret1, $secret2)
    {
        $this->url = $url;
        $this->secret1 = $secret1;
        $this->secret2 = $secret2;
    }

    /**
     * @param string $type
     * @param string $event
     * @param array $data
     * @return ResponseInterface
     * @throws Exception
     */
    public function push($type, $event, array $data)
    {
        $client = new Client();

        $headers = [
            'Content-Type' => 'application/json',
            'X-Customer-Secret1' => $this->secret1,
            'X-Customer-Secret2' => $this->secret2
        ];

        $data['type'] = $type;
        $data['event'] = $event;

        $request = new Request('POST', $this->url, $headers, json_encode($data));

        try {
            $response = $client->send($request);

            if ($this->listener){
                call_user_func($this->listener, $request, $response);
            }

        } catch (Exception $exception){

            if ($this->listener){
                call_user_func($this->listener, $request, $exception);
            }

            throw $exception;
        }

        return $response;
    }

    /**
     * @param callable $listener
     * @return $this
     */
    public function setListener(callable $listener)
    {
        $this->listener = $listener;
        return $this;
    }
}