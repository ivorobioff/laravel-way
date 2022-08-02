<?php
namespace RealEstate\Core\Appraisal\Enums;
use Restate\Libraries\Enum\Enum;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AssetType extends Enum
{
    const LOAN = 'loan';
    const ORE = 'ore';
    const SETTLEMENT = 'settlement';
}