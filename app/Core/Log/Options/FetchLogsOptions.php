<?php
namespace RealEstate\Core\Log\Options;

use RealEstate\Core\Shared\Options\CriteriaAwareTrait;
use RealEstate\Core\Shared\Options\PaginationAwareTrait;
use RealEstate\Core\Shared\Options\SortablesAwareTrait;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FetchLogsOptions
{
	use PaginationAwareTrait;
	use SortablesAwareTrait;
	use CriteriaAwareTrait;
}