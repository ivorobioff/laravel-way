<?php
namespace RealEstate\Api\Shared\Protectors;

use Restate\Libraries\Permissions\ProtectorInterface;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AllProtector implements ProtectorInterface
{
    /**
     * @return bool
     */
    public function grants()
    {
        return true;
    }
}