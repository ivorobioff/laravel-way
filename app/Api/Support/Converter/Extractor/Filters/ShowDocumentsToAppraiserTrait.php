<?php
namespace RealEstate\Api\Support\Converter\Extractor\Filters;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Appraisal\Entities\Document;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Company\Entities\Manager;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait ShowDocumentsToAppraiserTrait
{
    /**
     * @param Document $document
     * @param Session $session
     * @param EnvironmentInterface $environment
     * @return bool
     */
    private function canShowDocumentsToAppraiser(Document $document, Session $session, EnvironmentInterface $environment)
    {
        if ($environment->isRelaxed()){
            return true;
        }

        $actsAsAssignee = $environment->getAssigneeAsWhoActorActs() !== null;

        $user = $session->getUser();

        if ($document->getShowToAppraiser() === false
            && ($user instanceof Amc
                || $user instanceof Appraiser
                || $user instanceof Manager
                || ($user instanceof Customer && $actsAsAssignee))){

            return false;
        }

        return true;
    }
}