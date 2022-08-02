<?php
namespace RealEstate\Api\Support;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use RealEstate\Api\Support\Converter\Populator\PopulatorFactory;
use Restate\Libraries\Processor\PopulatorFactoryInterface;
use Restate\Libraries\Processor\SharedModifiers as ProcessorModifiers;
use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Transformer\AbstractTransformer;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Core\Session\Services\SessionService;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(PopulatorFactoryInterface::class, PopulatorFactory::class);

        /**
         * Registers shared modifiers for all processors
         */
        AbstractProcessor::setSharedModifiersProvider(new ProcessorModifiers());

        /**
         * Registers shared modifiers for all transformers
         */
        AbstractTransformer::setSharedModifiersProvider(new TransformerModifiers($this->app));
    }

    public function register()
    {
		$this->app->singleton(Session::class, function(){
			/**
			 * @var Request $request
			 */
			$request = $this->app->make('request');

			$token = $request->header('Token');

			if (!$token) {
				return new Session();
			}

			/**
			 * @var SessionService $sessionService
			 */
			$sessionService = $this->app->make(SessionService::class);

			$session = $sessionService->getByToken($token);

			if (!$session){
				return new Session();
			}

			return $session;
		});
	}
}
