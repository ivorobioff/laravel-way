<?php
namespace RealEstate\Core\Appraiser\Validation\Definers;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\SourceHandlerInterface;
use DateTime;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Core\Document\Validation\DocumentInflator;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class EoDefiner
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var bool
     */
    private $isRelaxed;

    /**
     * @var bool
     */
    private $bypassExpiresAt = false;

    /**
     * @var bool
     */
    private $isAllOptional = false;

    /**
     * Validates object only when it's specified
     *
     * @var bool
     */
    private $onlyWhenSpecified = false;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @var Document
     */
    private $trustedDocument;

    /**
     * @param Binder $binder
     */
    public function define(Binder $binder)
    {
        $inflator = new DocumentInflator($this->container);

        if ($this->trustedDocument){
            $inflator->setTrustedDocuments([$this->trustedDocument]);
        }

        $inflator->setRequired($this->isAllOptional === false);

        $onlyWhenSpecified = $this->onlyWhenSpecified;

        $when = function (SourceHandlerInterface $source) use ($onlyWhenSpecified) {
            if (!$onlyWhenSpecified) {
                return true;
            }

            return $source->hasProperty('eo');
        };

        $binder->bind('eo.document', $inflator)
            ->when($when);

        $binder->bind('eo.claimAmount', function (Property $property) {

            if (!$this->isAllOptional){
                $property->addRule(new Obligate());
            }

            $property->addRule(new Greater(0));
        })->when($when);

        $binder->bind('eo.aggregateAmount', function (Property $property) {

            if (!$this->isAllOptional){
                $property->addRule(new Obligate());
            }

            $property->addRule(new Greater(0));
        })->when($when);

        $binder->bind('eo.expiresAt', function (Property $property) {

            if (!$this->isRelaxed && !$this->isAllOptional){
                $property->addRule(new Obligate());
            }

            if ($this->bypassExpiresAt === false){
                $property->addRule(new Greater(new DateTime()));
            }
        })->when($when);

        $binder->bind('eo.carrier', function (Property $property) {
            $property
                ->addRule(new Blank());
        })->when($when);

        $binder->bind('eo.deductible', function (Property $property) {
            $property
                ->addRule(new Greater(0));
        })->when($when);
    }

    /**
     * @param int $flag
     * @return $this
     */
    public function setBypassExpiresAt($flag)
    {
        $this->bypassExpiresAt = $flag;

        return $this;
    }

    /**
     * @param int $flag
     * @return $this
     */
    public function setRelaxed($flag)
    {
        $this->isRelaxed = $flag;

        return $this;
    }

    /**
     * @param Document $document
     * @return $this
     */
    public function setTrustedDocument(Document $document)
    {
        $this->trustedDocument = $document;

        return $this;
    }

    /**
     * @param bool $flag
     * @return $this
     */
    public function setAllOptional($flag)
    {
        $this->isAllOptional = $flag;
        return $this;
    }

    /**
     * @param bool $flag
     * @return $this
     */
    public function setOnlyWhenSpecified($flag)
    {
        $this->onlyWhenSpecified = $flag;
        return $this;
    }
}