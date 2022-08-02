<?php
namespace RealEstate\Debug\Controllers;

use RealEstate\Console\Support\Kernel as Artisan;
use RealEstate\Debug\Support\BaseController;


/**
 * The controller is used to trigger artisan command for resetting the project
 *
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ResetController extends BaseController
{
	/**
	 * @param Artisan $artisan
	 * @return string
	 */
	public function reset(Artisan $artisan)
	{
		$artisan->call('project:reset');
		return 'The project has been reset successfully!';
	}
}