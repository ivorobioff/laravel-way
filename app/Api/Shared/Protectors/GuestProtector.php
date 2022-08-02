<?php
namespace RealEstate\Api\Shared\Protectors;

use Restate\Libraries\Permissions\ProtectorInterface;
use Illuminate\Http\Request;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class GuestProtector implements ProtectorInterface
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return bool
     */
    public function grants()
    {
        return ! $this->request->header('token');
    }
}