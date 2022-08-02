<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Push\Support\Call;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait CallsCapableTrait
{
    /**
     * @param Amc $amc
     * @return Call[]
     */
    protected function createCalls(Amc $amc)
    {
        $url = $amc->getSettings()->getPushUrl();

        if ($url === null){
            return [];
        }

        $call = new Call();

        $call->setUrl($url);
        $call->setSecret1($amc->getSecret1());
        $call->setSecret2($amc->getSecret2());

        return [$call];
    }
}