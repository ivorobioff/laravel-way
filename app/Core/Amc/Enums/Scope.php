<?php
namespace RealEstate\Core\Amc\Enums;
use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Scope extends Enum
{
    const NORMAL = 'normal';
    const BY_STATE = 'by-state';
    const BY_COUNTY = 'by-county';
    const BY_ZIP = 'by-zip';
}