<?php
namespace RealEstate\Console\Cron;

use Illuminate\Console\Command;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Core\Session\Services\SessionService;

/**
 * @author Sergei Melnikov <me@rnr.name>
 */
abstract class AbstractCommand extends Command
{
    public function __construct()
    {
        $this->name = 'cron:' . snake_case(cut_string_right(short_name(get_class($this)), 'Command'), '-');

        parent::__construct();
    }

    protected function startSystemSession()
    {
        $this->laravel->singleton(Session::class, function($app){
            /**
             * @var SessionService $sessionService
             */
            $sessionService = $app->make(SessionService::class);

            return $sessionService->createSystem();
        });
    }

    protected function endSystemSession()
    {
        /**
         * @var SessionService $sessionService
         */
        $sessionService = $this->laravel->make(SessionService::class);

        $sessionService->deleteSystem();

        unset($this->laravel[Session::class]);
    }
}