<?php
namespace RealEstate\Api\Appraiser\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Appraiser\V2_0\Controllers\AppraisersController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Appraisers implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('appraisers', AppraisersController::class, [
            'except' => ['destroy']
        ]);

		$registrar->post(
			'appraisers/{appraiserId}/change-primary-license',
			AppraisersController::class.'@changePrimaryLicense'
		);


		$registrar->patch(
			'appraisers/{appraiserId}/availability',
			AppraisersController::class.'@updateAvailability'
		);
    }
}