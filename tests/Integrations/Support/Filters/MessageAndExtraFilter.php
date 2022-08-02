<?php
namespace RealEstate\Tests\Integrations\Support\Filters;

use Restate\QA\Support\Filters\FilterInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class MessageAndExtraFilter implements FilterInterface
{
    /**
     * @param array $data
     * @return array
     */
    public function filter(array $data)
    {
        $result = [];

        foreach ($data as $key => $value){
            unset($value['message'], $value['extra']);
            $result[$key] = $value;
        }

        return $result;
    }
}