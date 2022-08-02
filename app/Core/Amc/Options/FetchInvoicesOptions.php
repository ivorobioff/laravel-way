<?php
namespace RealEstate\Core\Amc\Options;
use RealEstate\Core\Shared\Options\CriteriaAwareTrait;
use RealEstate\Core\Shared\Options\PaginationAwareTrait;
use RealEstate\Core\Shared\Options\SortablesAwareTrait;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FetchInvoicesOptions
{
    use SortablesAwareTrait;
    use CriteriaAwareTrait;
    use PaginationAwareTrait;
}