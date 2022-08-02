<?php
namespace RealEstate\DAL\Location\Support;
use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Error extends Enum
{
    const DENIED = 'denied';
    const INVALID = 'invalid';
    const OVER_QUERY_LIMIT = 'over-query-limit';
    const ZERO_RESULTS = 'zero-results';
    const SERVER = 'server';
    const UNKNOWN = 'unknown';
}