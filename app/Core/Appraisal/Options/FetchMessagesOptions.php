<?php
namespace RealEstate\Core\Appraisal\Options;

use RealEstate\Core\Shared\Options\CriteriaAwareTrait;
use RealEstate\Core\Shared\Options\PaginationAwareTrait;
use RealEstate\Core\Shared\Options\SortablesAwareTrait;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FetchMessagesOptions
{
	use PaginationAwareTrait;
	use SortablesAwareTrait;
	use CriteriaAwareTrait;
}