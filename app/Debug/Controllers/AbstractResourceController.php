<?php
namespace RealEstate\Debug\Controllers;

use Illuminate\Http\Request;
use RealEstate\Debug\Support\BaseController;
use RealEstate\Debug\Support\Storage;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractResourceController extends BaseController
{
	/**
	 * @var Storage
	 */
	protected $storage;

	/**
	 * @var string
	 */
	protected $file = '';

	public function __construct()
	{
		$this->storage = new Storage($this->file);
	}

	/**
	 * @return string
	 */
	public function index()
	{
		return $this->storage->dump();
	}

	public function destroy()
	{
		$this->storage->drop();
	}

	public function store(Request $request)
	{
		$this->storage->store(json_decode($request->getContent(), true));
	}
}