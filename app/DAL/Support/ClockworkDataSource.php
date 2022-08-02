<?php
namespace RealEstate\DAL\Support;

use Restate\Libraries\Enum\Enum;
use Restate\Libraries\Enum\EnumCollection;
use Clockwork\DataSource\DoctrineDataSource;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ClockworkDataSource extends DoctrineDataSource
{
	const PARAM_NOTHING = '...';

	protected function convertParam($param)
	{
		if (is_array($param)){
			$result = '';
			$d = '';

			foreach ($param as $item){
				if (is_array($item)){
					return static::PARAM_NOTHING;
				}

				$result .= $d.$this->convertParam($item);
				$d = ',';
			}

			return $result;
		}

		if (is_string($param)){
			return $param;
		}

		if (is_bool($param)){
			return $param ? '1' : '0';
		}

		if (is_int($param) || is_float($param)){
			return (string) $param;
		}

		if ($param instanceof Enum){
			return $param->value();
		}

		if ($param instanceof EnumCollection){
			return implode(',', $param->toArray());
		}

		if ($param instanceof DateTime){
			return $param->format('Y-m-d H:i:s');
		}

		return static::PARAM_NOTHING;
	}
}