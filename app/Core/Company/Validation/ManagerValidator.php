<?php
namespace RealEstate\Core\Company\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use RealEstate\Core\Company\Entities\Manager;
use RealEstate\Core\Company\Validation\Definers\ManagerDefiner;
use RealEstate\Core\Support\Service\ContainerInterface;


class ManagerValidator extends AbstractThrowableValidator
{
    /**
     * @var ManagerDefiner
     */
    private $definer;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->definer = new ManagerDefiner($container);
    }

    /**
     * @param Binder $binder
     */
    protected function define(Binder $binder)
    {
        $this->definer->define($binder);
    }

    /**
     * @param Manager $manager
     * @return $this
     */
    public function setCurrentManager(Manager $manager)
    {
        $this->definer->setCurrentManager($manager);
        return $this;
    }
}
