<?php
namespace  RealEstate\Core\Appraisal\Interfaces;

use RealEstate\Core\Document\Persistables\DocumentPersistable as SourcePersistable;
use RealEstate\Core\Document\Entities\Document as Source;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ExtractorInterface
{
    /**
     * @param Source $source
     * @return SourcePersistable[]
     */
    public function fromEnv(Source $source);

    /**
     * @param Source $source
     * @return SourcePersistable
     */
    public function fromXml(Source $source);
}