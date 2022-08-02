<?php
namespace RealEstate\Push\Support;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Foundation\Application;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Listener
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Application $application
     */
    private $application;

    /**
     * @param EntityManagerInterface $entityManager
     * @param Application $application
     */
    public function __construct(EntityManagerInterface $entityManager, Application $application)
    {
        $this->entityManager = $entityManager;
        $this->application = $application;
    }

    /**
     * @param Request $request
     * @param Response|Exception $responseOrException
     */
    public function __invoke(Request $request, $responseOrException)
    {
        // we don't want to log things when testing

        if ($this->application->environment() === 'tests'){
            return ;
        }

        $story = new Story();

        $request = [
            'url' => (string) $request->getUri(),
            'method' => strtoupper($request->getMethod()),
            'headers' => array_map(function($header){ return $header[0]; }, $request->getHeaders()),
            'body' => (string) $request->getBody()
        ];

        $story->setRequest($request);

        if ($responseOrException instanceof Exception){
            $error = [
                'code' => $responseOrException->getCode(),
                'message' => $responseOrException->getMessage(),
                'file' => $responseOrException->getFile(),
                'line' => $responseOrException->getLine(),
                'trace' => $responseOrException->getTrace()

            ];

            $story->setError($error);

            if ($responseOrException instanceof BadResponseException){

                $response = $responseOrException->getResponse();

                $story->setResponse([
                    'status' => $response->getStatusCode(),
                    'body' => (string) $response->getBody()
                ]);
            }

        } else {
            $story->setResponse([
                'status' => $responseOrException->getStatusCode(),
                'body' => (string) $responseOrException->getBody()
            ]);
        }

        $this->entityManager->persist($story);
        $this->entityManager->flush();
    }
}