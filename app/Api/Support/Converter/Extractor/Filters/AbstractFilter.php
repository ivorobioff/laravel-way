<?php
namespace RealEstate\Api\Support\Converter\Extractor\Filters;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use RealEstate\Api\Support\Converter\Extractor\FilterInterface;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var EnvironmentInterface
     */
    protected $environment;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->session = $container->make(Session::class);
        $this->request = $container->make('request');
        $this->environment = $container->make(EnvironmentInterface::class);
    }

    /**
     * @return bool
     */
    protected function isPost()
    {
        return $this->request->method() === Request::METHOD_POST;
    }

    /**
     * @return string
     */
    protected function getRoute()
    {
        return $this->request->route()->getPath();
    }
}