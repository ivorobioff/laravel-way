<?php
namespace RealEstate\Core\Company\Validation;
use Restate\Libraries\Validation\Binder;
use RealEstate\Core\Company\Validation\Definers\ManagerDefiner;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ManagerAsStaffValidator extends StaffValidator
{
    protected function define(Binder $binder)
    {
        parent::define($binder);

        $manager = new ManagerDefiner($this->container);
        $manager->setNamespace('user');

        $manager->define($binder);

    }
}