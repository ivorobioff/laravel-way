<?php
namespace RealEstate\Core\Appraiser\Options;

use RealEstate\Core\Shared\Options\CriteriaAwareTrait;
use RealEstate\Core\Shared\Options\PaginationAwareTrait;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FetchAppraisersOptions
{
	use PaginationAwareTrait;
	use CriteriaAwareTrait;
}