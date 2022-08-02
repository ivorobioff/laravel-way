<?php
namespace RealEstate\Api\Support;

use Restate\Libraries\Kangaroo\Pagination\AdapterInterface;
use Restate\Libraries\Kangaroo\Pagination\Paginator;
use Restate\Libraries\Permissions\PermissionsRequirableInterface;
use Restate\Libraries\Verifier\ActionVerifiableInterface;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Restate\Libraries\Transformer\AbstractTransformer;
use RuntimeException;
use Restate\Libraries\Kangaroo\Resource\Manager as ResourceManager;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class BaseController extends Controller implements PermissionsRequirableInterface, ActionVerifiableInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var ResourceManager
     */
    protected $resource;

    /**
     * BaseController constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->resource = $this->container->make(ResourceManager::class);

        if (method_exists($this, 'initialize')) {
            $this->container->call([$this, 'initialize']);
        }
    }

    /**
     * @param string $class
     * @return AbstractTransformer
     * @throws RuntimeException
     */
    protected function transformer($class = DefaultTransformer::class)
    {
        /**
         * @var TransformerFactory $factory
         */
        $factory = $this->container->make(TransformerFactory::class);

        /**
         * @var Request $request
         */
        $request = $this->container->make(Request::class);
        $input = $request->header('Include');

        $fields = $input ? array_map('trim', explode(',', $input)) : [];

        $config = $this->container->make('config')->get('transformer');

        return $factory->create($class, $config)->setIncludes($fields);
    }
    
	/**
	 * @param AdapterInterface $adapter
	 * @return Paginator
	 */
	protected function paginator(AdapterInterface $adapter)
	{
        Paginator::setRequest($this->container->make(Request::class));

        return new Paginator($adapter);
	}
}
