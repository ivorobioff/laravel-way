<?php
namespace RealEstate\Api\Document\V2_0\Protectors;

use Restate\Libraries\Permissions\ProtectorInterface;
use Illuminate\Http\Request;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FriendProtector implements ProtectorInterface
{
	/**
	 * @var Request
	 */
	private $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	/**
	 * @return bool
	 */
	public function grants()
	{
		$identifier = $this->request->header('System-Identifier');

		return $identifier === 'muw0t5dFsRsQIMsJoiBr3vTlMunW1d8Z';
	}
}