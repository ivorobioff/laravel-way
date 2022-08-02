<?php
namespace RealEstate\Live\Support;

use Restate\Libraries\Transformer\AbstractTransformer;
use Illuminate\Contracts\Container\Container;
use RealEstate\Api\Support\DefaultTransformer;
use RealEstate\Api\Support\TransformerFactory;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractHandler implements HandlerInterface
{
	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * @var TransformerFactory
	 */
	private $transformerFactory;

	/**
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
		$this->transformerFactory = $container->make(TransformerFactory::class);
	}

	/**
	 * @param object $notification
	 * @return Event
	 */
	public function handle($notification)
	{
		$channels = $this->getChannels($notification);

		if (!$channels){
			return null;
		}

		$event = new Event();

		$event->setType($this->getType());
		$event->setName($this->getName());
		$event->setChannels($channels);
		$event->setData($this->getData($notification));

		return $event;
	}

	/**
	 * @return string
	 */
	protected abstract function getType();

	/**
	 * @return string
	 */
	protected abstract function getName();

	/**
	 * @param object $notification
	 * @return Channel[]
	 */
	protected abstract function getChannels($notification);

	/**
	 * @param object $notification
	 * @return array
	 */
	protected abstract function getData($notification);

	/**
	 * @param string $class
	 * @return AbstractTransformer
	 */
	protected function transformer($class = DefaultTransformer::class)
	{
	    $config = $this->container->make('config')->get('transformer');

        unset($config['filter'], $config['filters']);

		return $this->transformerFactory->create($class, $config);
	}
}